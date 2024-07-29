<?php

namespace NextDeveloper\Agreement\Services;

class SignatureService
{

    private $client;

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        $defaultService = config('agreement.defaults.service');
        $serviceClass = config("agreement.services.{$defaultService}.class");

        if (!$defaultService || !$serviceClass) {
            throw new \Exception('Service class not found.');
        }

        $this->client = new $serviceClass();
    }

    /**
     * @throws \Exception
     */
    public function getAgreement($agreementId)
    {
        return $this->client->getAgreement($agreementId);
    }

    public function createDocument(string $documentName, $templateId = null)
    {

        $templateId = $templateId ?? config('agreement.defaults.template_id');

        return $this->client->createDocumentFromTemplate($templateId, $documentName);
    }

    public function fillDocumentWithData($documentId, $data)
    {
        return $this->client->fillDocumentWithData($documentId, $data);
    }

    public function downloadDocument($documentId)
    {
        return $this->client->downloadDocumentById($documentId);
    }


}
