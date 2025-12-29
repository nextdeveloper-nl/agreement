<?php

namespace NextDeveloper\Agreement\Exceptions;

use Exception;
use Throwable;

/**
 * Exception class for agreement-related errors.
 * Provides detailed error information for the agreement flow.
 */
class AgreementException extends Exception
{
    public const ERROR_TEMPLATE_NOT_FOUND = 'TEMPLATE_NOT_FOUND';
    public const ERROR_TEMPLATE_CLASS_INVALID = 'TEMPLATE_CLASS_INVALID';
    public const ERROR_IAM_ACCOUNT_NOT_FOUND = 'IAM_ACCOUNT_NOT_FOUND';
    public const ERROR_USER_NOT_FOUND = 'USER_NOT_FOUND';
    public const ERROR_MISSING_REQUIRED_FIELDS = 'MISSING_REQUIRED_FIELDS';
    public const ERROR_DOCUMENT_CREATION_FAILED = 'DOCUMENT_CREATION_FAILED';
    public const ERROR_CONTRACT_SEND_FAILED = 'CONTRACT_SEND_FAILED';
    public const ERROR_PROVIDER_ERROR = 'PROVIDER_ERROR';

    /**
     * @var string The error code for categorizing the error.
     */
    protected string $errorCode;

    /**
     * @var array Additional context data about the error.
     */
    protected array $context;

    /**
     * AgreementException constructor.
     *
     * @param string $message The error message.
     * @param string $errorCode The error code for categorizing the error.
     * @param array $context Additional context data about the error.
     * @param int $code The exception code.
     * @param Throwable|null $previous The previous throwable used for exception chaining.
     */
    public function __construct(
        string $message,
        string $errorCode = 'UNKNOWN_ERROR',
        array $context = [],
        int $code = 0,
        ?Throwable $previous = null
    ) {
        $this->errorCode = $errorCode;
        $this->context = $context;

        parent::__construct($message, $code, $previous);
    }

    /**
     * Get the error code.
     *
     * @return string The error code.
     */
    public function getErrorCode(): string
    {
        return $this->errorCode;
    }

    /**
     * Get the context data.
     *
     * @return array The context data.
     */
    public function getContext(): array
    {
        return $this->context;
    }

    /**
     * Get a formatted error message with context.
     *
     * @return string The formatted error message.
     */
    public function getDetailedMessage(): string
    {
        $details = "[$this->errorCode] {$this->getMessage()}";

        if (!empty($this->context)) {
            $details .= ' | Context: ' . json_encode($this->context);
        }

        return $details;
    }

    /**
     * Convert the exception to an array for API responses.
     *
     * @return array The exception data as an array.
     */
    public function toArray(): array
    {
        return [
            'error' => true,
            'error_code' => $this->errorCode,
            'message' => $this->getMessage(),
            'context' => $this->context,
        ];
    }

    /**
     * Create a template not found exception.
     *
     * @param string $slug The template slug that was not found.
     * @param int|null $accountId The account ID used in the search.
     * @return static
     */
    public static function templateNotFound(string $slug, ?int $accountId = null): static
    {
        return new static(
            "Agreement template with slug '{$slug}' not found.",
            self::ERROR_TEMPLATE_NOT_FOUND,
            ['slug' => $slug, 'account_id' => $accountId]
        );
    }

    /**
     * Create a template class invalid exception.
     *
     * @param string|null $className The invalid class name.
     * @param string $templateSlug The template slug.
     * @return static
     */
    public static function templateClassInvalid(?string $className, string $templateSlug): static
    {
        return new static(
            "Template class does not exist or is invalid: " . ($className ?? 'null'),
            self::ERROR_TEMPLATE_CLASS_INVALID,
            ['class' => $className, 'template_slug' => $templateSlug]
        );
    }

    /**
     * Create an IAM account not found exception.
     *
     * @param int $crmAccountId The CRM account ID.
     * @return static
     */
    public static function iamAccountNotFound(int $crmAccountId): static
    {
        return new static(
            "IAM Account not found for CRM Account ID: {$crmAccountId}",
            self::ERROR_IAM_ACCOUNT_NOT_FOUND,
            ['crm_account_id' => $crmAccountId]
        );
    }

    /**
     * Create a user not found exception.
     *
     * @param int $iamAccountId The IAM account ID.
     * @return static
     */
    public static function userNotFound(int $iamAccountId): static
    {
        return new static(
            "Account owner not found for IAM Account ID: {$iamAccountId}",
            self::ERROR_USER_NOT_FOUND,
            ['iam_account_id' => $iamAccountId]
        );
    }

    /**
     * Create a missing required fields exception.
     *
     * @param array $missingFields The list of missing fields.
     * @param string $agreementName The agreement name.
     * @return static
     */
    public static function missingRequiredFields(array $missingFields, string $agreementName): static
    {
        return new static(
            "Missing required fields for agreement '{$agreementName}': " . implode(', ', array_values($missingFields)),
            self::ERROR_MISSING_REQUIRED_FIELDS,
            ['missing_fields' => $missingFields, 'agreement_name' => $agreementName]
        );
    }

    /**
     * Create a document creation failed exception.
     *
     * @param string $templateId The template ID.
     * @param string|null $reason The reason for failure.
     * @return static
     */
    public static function documentCreationFailed(string $templateId, ?string $reason = null): static
    {
        return new static(
            "Failed to create document from template: " . ($reason ?? 'Unknown reason'),
            self::ERROR_DOCUMENT_CREATION_FAILED,
            ['template_id' => $templateId, 'reason' => $reason]
        );
    }

    /**
     * Create a contract send failed exception.
     *
     * @param string $contractReference The contract reference.
     * @param array $providerResponse The provider response data.
     * @return static
     */
    public static function contractSendFailed(string $contractReference, array $providerResponse = []): static
    {
        $message = $providerResponse['message'] ?? 'Failed to send contract to provider';

        return new static(
            $message,
            self::ERROR_CONTRACT_SEND_FAILED,
            ['contract_reference' => $contractReference, 'provider_response' => $providerResponse]
        );
    }

    /**
     * Create a provider error exception.
     *
     * @param string $message The error message from the provider.
     * @param array $providerResponse The full provider response.
     * @return static
     */
    public static function providerError(string $message, array $providerResponse = []): static
    {
        return new static(
            "Provider error: {$message}",
            self::ERROR_PROVIDER_ERROR,
            ['provider_response' => $providerResponse]
        );
    }
}
