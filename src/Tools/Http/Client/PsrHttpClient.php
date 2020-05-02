<?php

namespace Sokil\Viber\Notifier\Tools\Http\Client;

use Fig\Http\Message\RequestMethodInterface;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Sokil\Viber\Notifier\Service\ViberClient\Exception\CanNotSetWebHookException;

class PsrHttpClient implements HttpClientInterface
{
    /**
     * @var ClientInterface
     */
    private $httpClient;

    /**
     * @var RequestFactoryInterface
     */
    private $httpRequestFactory;

    /**
     * @var StreamFactoryInterface
     */
    private $httpStreamFactoryInterface;

    /**
     * @param ClientInterface $httpClient
     * @param RequestFactoryInterface $httpRequestFactory
     * @param StreamFactoryInterface $httpStreamFactoryInterface
     */
    public function __construct(
        ClientInterface $httpClient,
        RequestFactoryInterface $httpRequestFactory,
        StreamFactoryInterface $httpStreamFactoryInterface
    ) {
        $this->httpClient = $httpClient;
        $this->httpRequestFactory = $httpRequestFactory;
        $this->httpStreamFactoryInterface = $httpStreamFactoryInterface;
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
        $requestBody = $this->httpStreamFactoryInterface->createStream(
            \json_encode($body)
        );

        $request = $this->httpRequestFactory->createRequest(
            RequestMethodInterface::METHOD_POST,
            $uri
        );

        foreach ($headers as $headerName => $headerValue) {
            $request = $request->withHeader($headerName, $headerValue);
        }

        $request = $request->withBody($requestBody);

        try {
            $response = $this->httpClient->sendRequest($request);
        } catch (ClientExceptionInterface $e) {
            throw new CanNotSetWebHookException($e->getMessage(), $e->getCode(), $e);
        }

        $responseBody = \json_decode($response->getBody()->getContents(), true);

        return $responseBody;
    }
}