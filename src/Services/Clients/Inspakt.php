<?php

namespace NextDeveloper\Agreement\Services\Clients;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Inspakt
{

    protected $client;

    /**
     * @throws \Exception
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
                'Api-Key' => $apiKey,
                'Accept' => 'application/json',
            ],
        ]);

    }

    /**
     * @throws GuzzleException
     */
    public function getAgreement($agreementId)
    {
        $response = $this->client->get("office/external/template/{$agreementId}");
        return json_decode($response->getBody()->getContents(), true);
    }

}
