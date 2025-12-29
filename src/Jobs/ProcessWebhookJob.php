<?php

namespace NextDeveloper\Agreement\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use NextDeveloper\Agreement\Database\Models\Contracts;
use NextDeveloper\Agreement\Database\Models\Webhooks;
use NextDeveloper\IAM\Database\Scopes\AuthorizationScope;
use NextDeveloper\IAM\Helpers\UserHelper;

/**
 * Class ProcessWebhookJob
 *
 * This job processes webhooks related to agreements. It checks for unprocessed webhooks,
 * updates contract statuses, saves them, and marks the webhooks as processed.
 *
 * @package NextDeveloper\Agreement\Jobs
 */
class ProcessWebhookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The name of the queue on which this job will be placed.
     */
    public const QUEUE_NAME = 'agreement';

    /**
     * Supported webhook events
     */
    public const EVENT_DOCUMENT_SIGNED = 'DOCUMENT_SIGNED';

    /**
     * Supported signer sides
     */
    const SIDE_INITIAL = 'INITIAL';
    const SIDE_COUNTER = 'COUNTER';

    /**
     * ProcessWebhookJob constructor.
     *
     * Sets the queue name for this job.
     */
    public function __construct()
    {

        UserHelper::setAdminAsCurrentUser();
        $this->onQueue(self::QUEUE_NAME);
    }

    /**
     * Handle the job.
     *
     * This method processes the webhooks by performing the following steps:
     * 1. Log the start of the process.
     * 2. Select unprocessed webhooks from the database.
     * 3. Iterate over each webhook and process it within its own transaction.
     * 4. Validate webhook data structure.
     * 5. Check the event type and process only 'DOCUMENT_SIGNED' events.
     * 6. Update the contract status and store signer information.
     * 7. Download the signed document.
     * 8. Save the signed document to a temporary location.
     * 9. Delete the temporary file.
     * 10. Mark the webhook as processed.
     * 11. Log the successful processing of each webhook.
     * 12. Log any errors if an exception occurs for individual webhooks.
     */
    public function handle(): void
    {

        UserHelper::setAdminAsCurrentUser();

        Log::info("[Agreement::ProcessWebhookJob] Starting webhook processing");


        $webhooks = Webhooks::withoutGlobalScopes()
            ->where('is_processed', false)
            ->orderBy('created_at', 'asc')
            ->get();

        if ($webhooks->isEmpty()) {
            Log::info("[Agreement::ProcessWebhookJob] No unprocessed webhooks found");
            return;
        }

        Log::info("[Agreement::ProcessWebhookJob] Found {$webhooks->count()} unprocessed webhook(s)");

        foreach ($webhooks as $webhook) {
            $this->processWebhook($webhook);
        }


        Log::info("[Agreement::ProcessWebhookJob] Webhook processing completed");
    }

    /**
     * Process a single webhook within its own transaction.
     *
     * @param Webhooks $webhook
     * @return void
     * @throws \Throwable
     */
    private function processWebhook(Webhooks $webhook): void
    {
        Log::info("[Agreement::ProcessWebhookJob] Processing webhook: {$webhook->id}");

        DB::beginTransaction();
        try {
            $data = $this->getWebhookData($webhook);

            if (!$this->isValidWebhookData($data)) {
                $this->markWebhookAsProcessed($webhook, 'Invalid webhook data structure');
                DB::commit();
                return;
            }

            // Check for deprecated webhook (log warning but still process)
            if ($this->isDeprecated($data)) {
                Log::warning("[Agreement::ProcessWebhookJob] Processing deprecated webhook format: {$webhook->id}");
            }

            $event = $data['event'];

            if ($event !== self::EVENT_DOCUMENT_SIGNED) {
                $this->markWebhookAsProcessed($webhook, "Unsupported event type: {$event}");
                DB::commit();
                return;
            }

            $this->handleDocumentSignedEvent($webhook, $data);

            DB::commit();
            Log::info("[Agreement::ProcessWebhookJob] Webhook processed successfully: {$webhook->id}");

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("[Agreement::ProcessWebhookJob] Error processing webhook {$webhook->id}: " . $e->getMessage(), [
                'exception' => $e,
                'webhook_id' => $webhook->id,
            ]);
        }
    }

    /**
     * Get webhook data as an array.
     *
     * @param Webhooks $webhook
     * @return array
     */
    private function getWebhookData(Webhooks $webhook): array
    {
        $data = $webhook->data;

        // Handle both string (JSON) and already decoded array
        if (is_string($data)) {
            $data = json_decode($data, true) ?? [];
        }

        return is_array($data) ? $data : [];
    }

    /**
     * Validate webhook data structure.
     *
     * @param array $data
     * @return bool
     */
    private function isValidWebhookData(array $data): bool
    {
        // Must have an event key
        if (!array_key_exists('event', $data)) {
            Log::warning("[Agreement::ProcessWebhookJob] Missing 'event' key in webhook data");
            return false;
        }

        // Must have a data key with documentId for DOCUMENT_SIGNED events
        if ($data['event'] === self::EVENT_DOCUMENT_SIGNED) {
            if (!isset($data['data']['documentId'])) {
                Log::warning("[Agreement::ProcessWebhookJob] Missing 'data.documentId' in DOCUMENT_SIGNED webhook");
                return false;
            }
        }

        return true;
    }

    /**
     * Mark the webhook as processed.
     *
     * @param Webhooks $webhook
     * @param string|null $note Optional note about a processing result
     * @return void
     */
    private function markWebhookAsProcessed(Webhooks $webhook, ?string $note = null): void
    {
        $webhook->update(['is_processed' => true]);

        if ($note) {
            Log::info("[Agreement::ProcessWebhookJob] Webhook {$webhook->id} marked as processed: {$note}");
        }
    }

    /**
     * Check if a webhook is marked as deprecated.
     *
     * @param array $data
     * @return bool
     */
    private function isDeprecated(array $data): bool
    {
        return isset($data['deprecated']) && $data['deprecated'] === true;
    }

    /**
     * Handle DOCUMENT_SIGNED event.
     *
     * @param Webhooks $webhook
     * @param array $data
     * @return void
     */
    private function handleDocumentSignedEvent(Webhooks $webhook, array $data): void
    {
        $documentId = $data['data']['documentId'];
        $side = $data['data']['side'] ?? null;
        $signerInfo = $data['data']['signer'] ?? null;
        $webhookInfo = $data['webhook'] ?? null;

        Log::info("[Agreement::ProcessWebhookJob] Processing DOCUMENT_SIGNED for document: {$documentId}", [
            'side' => $side,
            'signer_email' => $signerInfo['email'] ?? 'unknown',
        ]);

        // Find the contract by reference
        $contract = Contracts::withoutGlobalScope(AuthorizationScope::class)
            ->where('reference', $documentId)
            ->first();

        if (!$contract) {
            Log::warning("[Agreement::ProcessWebhookJob] Contract not found for document: {$documentId}");
            $this->markWebhookAsProcessed($webhook, "Contract not found for document: {$documentId}");
            return;
        }

        // Update contract with signature information
        $this->updateContractSignatureStatus($contract, $side, $signerInfo);

        // Mark webhook as processed
        $this->markWebhookAsProcessed($webhook);
    }

    /**
     * Update contract signature status based on the signer side.
     *
     * @param Contracts $contract
     * @param string|null $side
     * @param array|null $signerInfo
     * @return void
     */
    private function updateContractSignatureStatus(Contracts $contract, ?string $side, ?array $signerInfo): void
    {
        $updateData = [
            'is_signed' => true,
        ];

        // Store signer information in the contract's data field
        $contractData = $contract->data ?? [];

        if (!isset($contractData['signatures'])) {
            $contractData['signatures'] = [];
        }

        // Add signature record
        $signatureRecord = [
            'signed_at' => now()->toIso8601String(),
            'side' => $side,
        ];

        if ($signerInfo) {
            $signatureRecord['signer'] = [
                'id' => $signerInfo['id'] ?? null,
                'type' => $signerInfo['type'] ?? null,
                'full_name' => $signerInfo['fullName'] ?? null,
                'email' => $signerInfo['email'] ?? null,
                'country_code' => $signerInfo['countryCode'] ?? null,
                'phone_number' => $signerInfo['phoneNumber'] ?? null,
            ];
        }

        $contractData['signatures'][] = $signatureRecord;
        $updateData['data'] = $contractData;

        $contract->updateQuietly($updateData);

        Log::info("[Agreement::ProcessWebhookJob] Contract signature status updated", [
            'contract_id' => $contract->id,
            'side' => $side,
            'signer_name' => $signerInfo['fullName'] ?? 'unknown',
        ]);
    }
}
