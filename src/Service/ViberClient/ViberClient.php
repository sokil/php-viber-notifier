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
        try {
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
        } catch (\Exception $e) {
            throw new CanNotSetWebHookException(
                'Error requesting Viber server to set web hook',
                $e->getCode(),
                $e
            );
        }

        // handle response error
        if (empty($response['status_message']) || $response['status_message'] !== 'ok') {
            throw new CanNotSetWebHookException(
                sprintf(
                    'Viber server returns error "%s" while trying to set web hool',
                    isset($response['status_message']) ? $response['status_message'] : 'none'
                )
            );
        }
    }

    /**
     * @param string $senderName
     * @param string $message
     * @param SubscriberIdCollection $subscriberIdCollection
     *
     * @return bool[]
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

        $wasSent = [];

        foreach ($subscriberIdCollection as $subscriberId) {
            try {
                $response = $this->httpClient->request(
                    self::BASE_URI . '/pa/send_message',
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
            } catch (\Exception $e) {
                $response = null;
            }

            $wasSent[$subscriberId->getValue()] = !empty($response['status_message'])
                && $response['status_message'] === 'ok';
        }

        return $wasSent;
    }
}