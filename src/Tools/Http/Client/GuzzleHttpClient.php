<?php

namespace Sokil\Viber\Notifier\Tools\Http\Client;

use GuzzleHttp\Client;

class GuzzleHttpClient implements HttpClientInterface
{
    /**
     * @var Client
     */
    private $httpClient;

    /**
     * @param Client $httpClient
     */
    public function __construct(
        Client $httpClient
    ) {
        $this->httpClient = $httpClient;
    }

    /**
     * @param string $uri
     * @param array $headers
     * @param array $body
     *
     * @return array
     */
    public function request($uri, array $headers, array $body)
    {
        $response = $this->httpClient->post(
            $uri,
            [
                'headers' => $headers,
                'body' => \json_encode($body),
            ]
        );

        return \json_decode($response->getBody()->getContents(), true);
    }
}