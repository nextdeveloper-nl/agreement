<?php

namespace NextDeveloper\Agreement\Services\Clients;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

/**
 * Service class to interact with the Inspakt API for agreement management.
 *
 * This class provides methods to retrieve and manage agreements and documents
 * through the Inspakt API. It requires an API key and URL to be configured
 * in the application's configuration file.
 */
class Inspakt
{
    /**
     * @var Client The Guzzle HTTP client instance.
     */
    protected Client $client;

    /**
     * Constructor for the InspaktService.
     *
     * Initializes the Guzzle HTTP client with the base URI and headers
     * required for the Inspakt API. The API key and URL must be set in the
     * application's configuration file.
     *
     * @throws \Exception If the API key or URL is not set in the configuration.
     */
    public function __construct()
    {
        $apiKey = config('agreement.services.inspakt.api_key');
        $apiUrl = config('agreement.services.inspakt.api_url');

        if (empty($apiKey) || empty($apiUrl)) {
            throw new \Exception('Inspakt API key or URL is not set.');
        }

        $this->client = new Client([
            'base_uri' => $apiUrl,
            'headers' => [
                'X-Inspakt-Api-Key' => $apiKey,
                'Accept' => 'application/json',
            ],
        ]);
    }

    /**
     * Retrieve agreement details by ID.
     *
     * Sends a GET request to the Inspakt API to retrieve the details of an
     * agreement specified by its ID.
     *
     * @param string $agreementId The ID of the agreement to retrieve.
     * @return array The agreement details.
     * @throws GuzzleException If the request fails.
     */
    public function getAgreementById(string $agreementId): array
    {
        $response = $this->client->get("office/external/template/{$agreementId}");
        return $this->decodeResponse($response);
    }

    /**
     * Create a new document based on a template.
     *
     * Sends a POST request to the Inspakt API to create a new document from a
     * specified template.
     *
     * @param string $templateId The ID of the template to use.
     * @param string $documentName The name of the new document.
     * @return string The ID of the created document.
     * @throws GuzzleException If the request fails.
     */
    public function createDocumentFromTemplate(string $templateId, string $documentName): string
    {
        $response = $this->client->post('office/external/document', [
            'json' => [
                'templateId' => $templateId,
                'name' => $documentName,
            ],
        ]);

        $responseData = $this->decodeResponse($response);
        return $responseData['payload']['document']['id'];
    }

    /**
     * Fill the document with the provided data.
     *
     * Sends a PUT request to the Inspakt API to fill a specified document with
     * data.
     *
     * @param string $documentId The ID of the document to fill.
     * @param array $data The data to fill the document with.
     * @return array The response from the API.
     * @throws GuzzleException If the request fails.
     */
    public function fillDocumentWithData(string $documentId, array $data): array
    {
        $response = $this->client->put("office/external/document/{$documentId}/fill", [
            'json' => [
                'complete' => true,
                'useMetaNames' => true,
                'data' => [
                    'fillScreen' => [
                        'identifier' => 'Customer #1',
                        'customer' => 'PlusClouds',
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'phone' => $data['phone'],
                    ]
                ],
                'signatureSettings' => [
                    [
                        'metaName' => 'customerSignature',
                        'preferredChannel' => $data['channel'],
                    ]
                ]
            ]
        ]);

        return $this->decodeResponse($response);
    }

    /**
     * Retrieve document details by ID.
     *
     * Sends a GET request to the Inspakt API to retrieve the details of a
     * document specified by its ID.
     *
     * @param string $documentId The ID of the document to retrieve.
     * @throws GuzzleException
     */
    public function getDocumentById(string $documentId): array
    {
        $response = $this->client->get("office/external/document/{$documentId}");
        return $this->decodeResponse($response);
    }

    /**
     * Download the document by ID.
     *
     * Sends a GET request to the Inspakt API to download the document specified
     * by its ID.
     *
     * @param string $documentId The ID of the document to download.
     * @return string The contents of the downloaded document.
     * @throws GuzzleException If the request fails.
     */
    public function downloadDocumentById(string $documentId): string
    {
        $response = $this->client->get("office/external/document/{$documentId}/download");
        return $response->getBody()->getContents();
    }

    /**
     * Decode the response from the API.
     *
     * @param mixed $response The response object from the API.
     * @return array The decoded response data.
     */
    private function decodeResponse(mixed $response): array
    {
        return json_decode($response->getBody()->getContents(), true);
    }
}
