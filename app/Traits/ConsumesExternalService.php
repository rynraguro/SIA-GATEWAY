<?php

namespace App\Traits;

// Include the Guzzle Component Library
use GuzzleHttp\Client;

trait ConsumesExternalService
{
    /**
     * Send a request to any service
     *
     * @param string $method
     * @param string $requestUrl
     * @param array $form_params (optional)
     * @param array $headers (optional)
     * @return string
     */
    public function performRequest($method, $requestUrl, $form_params = [], $headers = [])
    {
        // Create a new client request
        $client = new Client([
            'base_uri' => $this->baseUri,
        ]);

        if (!isset($headers['Authorization']) && isset($this->secret)) {
            $headers['Authorization'] = $this->secret;
        }        

        // Perform the request (method, URL, form parameters, headers)
        $response = $client->request($method, $requestUrl, ['form_params' =>
             $form_params, 'headers' => $headers,]);

        // Return the response body contents
        return $response->getBody()->getContents();
    }
}