<?php

namespace NextDeveloper\Agreement\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\UploadedFile;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use NextDeveloper\Agreement\Database\Models\Contracts;
use NextDeveloper\Agreement\Services\SignatureService;
use NextDeveloper\Commons\Services\MediaService;
use NextDeveloper\IAM\Database\Scopes\AuthorizationScope;
use Publitio\BadJSONResponse;

/**
 * Class ProcessWebhookJob
 *
 * This job processes webhooks related to agreements. It checks for unprocessed webhooks,
 * updates contract statuses, downloads signed documents, saves them, and marks the webhooks as processed.
 *
 * @package NextDeveloper\Agreement\Jobs
 */
class ProcessWebhookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The name of the queue on which this job will be placed.
     */
    const QUEUE_NAME = 'agreement';

    /**
     * ProcessWebhookJob constructor.
     *
     * Sets the queue name for this job.
     */
    public function __construct()
    {
        $this->onQueue(self::QUEUE_NAME);
    }

    /**
     * Handle the job.
     *
     * This method processes the webhooks by performing the following steps:
     * 1. Log the start of the process.
     * 2. Begin a database transaction.
     * 3. Select unprocessed webhooks from the database.
     * 4. Iterate over each webhook and processes it.
     * 5. Check the event type and processes only 'DOCUMENT_SIGNED' events.
     * 6. Updates the contract status to signed.
     * 7. Download the signed document.
     * 8. Save the signed document to a temporary location.
     * 9. Uploads the document using MediaService.
     * 10. Delete the temporary file.
     * 11. Marks the webhook as processed.
     * 12. Commits the transaction.
     * 13. Log the successful processing of webhooks.
     * 14. Rolls back the transaction and logs any errors if an exception occurs.
     *
     */
    public function handle(): void
    {
        Log::info("[Agreement::ProcessWebhookJob] Processing webhooks");

        DB::beginTransaction();
        try {
            // Check contract status
            $webhook = DB::select('SELECT * FROM agreement_webhooks WHERE is_processed is false');

            foreach ($webhook as $item) {
                Log::info("[Agreement::ProcessWebhookJob] Processing webhook: " . $item->id);

                $data = $item->data;
                $data = json_decode($data, true);

                if (!array_key_exists('event', $data)) {
                    continue;
                }

                if ($data['event'] !== 'DOCUMENT_SIGNED') {
                    continue;
                }

                $documentId = $data['data']['documentId'];

                // Update contract status
                $contract = Contracts::withoutGlobalScope(AuthorizationScope::class)
                    ->where('reference', $documentId)
                    ->first();

                if (!$contract) {
                    continue;
                }

                $contract->update([
                    'is_signed' => true,
                ]);

                $signerService = new SignatureService();
                $document = $signerService->downloadDocument($documentId);

                // Save signed document
                $path = storage_path('app/public/temp/' . $contract->uuid . '.pdf');
                // create directory if not exists
                if (!file_exists(dirname($path))) {
                    mkdir(dirname($path), 0777, true);
                }

                $file = fopen($path, 'w');
                fwrite($file, $document);
                fclose($file);

                // create an instance of MediaService
                $uploadedFile = new UploadedFile(
                    $path,
                    $contract->uuid . '.pdf',
                    'application/pdf'
                );

                MediaService::create([
                    'object_type' => 'NextDeveloper\\Agreement\\Database\\Models\\Contracts',
                    'object_id' => $contract->uuid,
                    'file' => $uploadedFile,
                ]);

                // Delete temp file
                unlink($path);

                // Mark webhook as processed
                DB::table('agreement_webhooks')
                    ->where('id', $item->id)
                    ->update(['is_processed' => 1]);

                DB::commit();

                Log::info("[Agreement::ProcessWebhookJob] Webhook processed: " . $item->id);
            }

            Log::info("[Agreement::ProcessWebhookJob] Webhooks processed successfully");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("[Agreement::ProcessWebhookJob] Error processing webhook: " . $e->getMessage());
        }
    }
}
