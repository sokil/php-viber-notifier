<?php

declare(strict_types=1);

namespace Sokil\Viber\Notifier\Tools\Http\Client;

use GuzzleHttp\Client;

class GuzzleHttpClient implements HttpClientInterface
{
    /**
     * @var Client
     */
    private $httpClient;

    /**
     */
    public function __construct(
        Client $httpClient
    ) {
        $this->httpClient = $httpClient;
    }

    /**
     * @param array $headers
     * @param array $body
     *
     * @return array
     */
    public function request(string $uri, array $headers, array $body)
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
