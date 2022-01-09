<?php

declare(strict_types=1);

namespace Sokil\Viber\Notifier\Service\ViberClient;

use Sokil\Viber\Notifier\Entity\SubscriberId;
use Sokil\Viber\Notifier\Entity\SubscriberIdCollection;
use Sokil\Viber\Notifier\Message\AbstractMessage;
use Sokil\Viber\Notifier\Service\ViberClient\Exception\ViberApiRequestError;
use Sokil\Viber\Notifier\Service\ViberClient\Status\Status;
use Sokil\Viber\Notifier\Service\ViberClient\Status\StatusCollection;
use Sokil\Viber\Notifier\Tools\Http\Client\HttpClientInterface;

/**
 * Basic implementation of Viber client
 */
class ViberClient implements ViberClientInterface
{
    const BASE_URI = 'https://chatapi.viber.com';

    const MAX_BROADCAST_RECEIVERS_ALLOWED = 300;

    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    /**
     * @var string
     */
    private $authToken;

    /**
     */
    public function __construct(HttpClientInterface $httpClient, string $authToken)
    {
        $this->httpClient = $httpClient;
        $this->authToken = $authToken;
    }

    /**
     * @param array $eventTypes = null If null, subscribe to all events. Possible values (message, delivered, seen, failed, subscribed, unsubscribed, conversation_started)
     * @throws ViberApiRequestError
     */
    public function setWebHookUrl(string $url, array $eventTypes = null)
    {
        try {
            $query = [
                "url" => (string)$url,
                "send_name" => true,
                "send_photo" => true,
            ];

            if (is_array($eventTypes)) {
                $query['event_types'] = $eventTypes;
            }

            $response = $this->httpClient->request(
                self::BASE_URI . '/pa/set_webhook',
                [
                    'X-Viber-Auth-Token' => $this->authToken,
                ],
                $query
            );
        } catch (\Exception $e) {
            throw new ViberApiRequestError(
                'Error requesting Viber server to set web hook',
                $e->getCode(),
                $e
            );
        }

        // handle response error
        if (!isset($response['status']) || $response['status'] !== Status::OK) {
            throw new ViberApiRequestError(
                sprintf(
                    'Viber server returns error "%s" while trying to set web hook',
                    isset($response['status_message']) ? $response['status_message'] : 'none'
                )
            );
        }
    }

    /**
     *
     * @return StatusCollection Failed statuses
     */
    public function broadcastMessage(
        string $senderName,
        AbstractMessage $message,
        SubscriberIdCollection $subscriberIdCollection
    ) {
        if (!is_string($senderName) || empty($senderName)) {
            throw new \InvalidArgumentException('Sender name not specified');
        }

        if (count($subscriberIdCollection) > self::MAX_BROADCAST_RECEIVERS_ALLOWED) {
            throw new \InvalidArgumentException(sprintf(
                'Can not send message to more than %s subscribers',
                self::MAX_BROADCAST_RECEIVERS_ALLOWED
            ));
        }

        try {
            $response = $this->httpClient->request(
                self::BASE_URI . '/pa/broadcast_message',
                [
                    'X-Viber-Auth-Token' => $this->authToken,
                ],
                [
                    'min_api_version' => $message->getMinimalApiVersion(),
                    'broadcast_list' => $subscriberIdCollection->toScalarArray(),
                    'sender' => [
                        'name' => $senderName,
                    ],
                    'type' => $message->getType(),
                ] + $message->toApiRequestParams()
            );
        } catch (\Exception $e) {
            throw new ViberApiRequestError(
                'Error requesting Viber server to send broadcast message',
                $e->getCode(),
                $e
            );
        }

        if (!isset($response['status']) || $response['status'] !== Status::OK) {
            throw new ViberApiRequestError(
                sprintf(
                    'Viber server returns error "%s" while trying to set send broadcast message',
                    isset($response['status_message']) ? $response['status_message'] : 'none'
                )
            );
        }

        // build collection of failed statuses
        $statusCollection = [];
        if (!empty($response['failed_list']) && is_array($response['failed_list'])) {
            foreach ($response['failed_list'] as $subscriberFailedStatus) {
                $statusCollection[$subscriberFailedStatus['receiver']] = new Status(
                    new SubscriberId($subscriberFailedStatus['receiver']),
                    (int)$subscriberFailedStatus['status'],
                    $subscriberFailedStatus['status_message']
                );
            }
        }

        return new StatusCollection($statusCollection);
    }

    /**
     *
     * @return Status
     */
    public function sendMessage(
        string $senderName,
        AbstractMessage $message,
        SubscriberId $subscriberId
    ) {
        if (!is_string($senderName) || empty($senderName)) {
            throw new \InvalidArgumentException('Sender name not specified');
        }

        try {
            $response = $this->httpClient->request(
                self::BASE_URI . '/pa/send_message',
                [
                    'X-Viber-Auth-Token' => $this->authToken,
                ],
                [
                    'min_api_version' => $message->getMinimalApiVersion(),
                    'receiver' => $subscriberId->getValue(),
                    'sender' => [
                        'name' => $senderName,
                    ],
                    'type' => $message->getType(),
                ] + $message->toApiRequestParams()
            );
        } catch (\Exception $e) {
            throw new ViberApiRequestError(
                'Error requesting Viber server to send message',
                $e->getCode(),
                $e
            );
        }

        return new Status(
            $subscriberId,
            (int)$response['status'],
            $response['status_message']
        );
    }
}
