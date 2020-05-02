<?php

namespace Sokil\Viber\Notifier\Service\ViberClient;

use Sokil\Viber\Notifier\Entity\SubscriberIdCollection;
use Sokil\Viber\Notifier\Service\ViberClient\Exception\CanNotSetWebHookException;
use Sokil\Viber\Notifier\Tools\Http\Client\HttpClientInterface;

/**
 * Basic implementation of Viber client
 */
class ViberClient implements ViberClientInterface
{
    const BASE_URI ='https://chatapi.viber.com';

    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    /**
     * @var string
     */
    private $authToken;

    /**
     * @param HttpClientInterface $httpClient
     * @param string $authToken
     */
    public function __construct(HttpClientInterface $httpClient, $authToken)
    {
        $this->httpClient = $httpClient;
        $this->authToken = $authToken;
    }

    /**
     * @param string $url
     *
     * @throws CanNotSetWebHookException
     */
    public function setWebHookUrl($url)
    {
        $response = $this->httpClient->request(
            self::BASE_URI . '/pa/set_webhook',
            [
                'X-Viber-Auth-Token' => $this->authToken,
            ],
            [
                "url" => (string)$url,
                "event_types" => [
                    "subscribed",
                    "unsubscribed",
                    "conversation_started",
                ],
                "send_name" => true,
                "send_photo" => true,
            ]
        );

        // handle response error
    }

    /**
     * @param string $senderName
     * @param string $message
     * @param SubscriberIdCollection $subscriberIdCollection
     */
    public function broadcastMessage(
        $senderName,
        $message,
        SubscriberIdCollection $subscriberIdCollection
    ) {
        if (!is_string($senderName) || empty($senderName)) {
            throw new \InvalidArgumentException('Sender name not specified');
        }

        if (!is_string($message) || empty($message)) {
            throw new \InvalidArgumentException('Message not specified');
        }

        $result = [];

        foreach ($subscriberIdCollection as $subscriberId) {
            $response = $this->httpClient->request(
                self::BASE_URI . '/pa/set_webhook',
                [
                    'X-Viber-Auth-Token' => $this->authToken,
                ],
                [
                    'receiver' => $subscriberId->getValue(),
                    'type' => 'text',
                    'sender' => [
                        'name' => $senderName,
                    ],
                    'text' => $message,
                ]
            );

            $result[$subscriberId->getUserId()] = $response;
        }

        // todo: handle response
    }
}