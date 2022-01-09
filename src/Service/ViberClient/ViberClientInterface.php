<?php

declare(strict_types=1);

namespace Sokil\Viber\Notifier\Service\ViberClient;

use Sokil\Viber\Notifier\Entity\SubscriberId;
use Sokil\Viber\Notifier\Entity\SubscriberIdCollection;
use Sokil\Viber\Notifier\Message\AbstractMessage;
use Sokil\Viber\Notifier\Service\ViberClient\Exception\ViberApiRequestError;
use Sokil\Viber\Notifier\Service\ViberClient\Status\Status;
use Sokil\Viber\Notifier\Service\ViberClient\Status\StatusCollection;

/**
 * If you already have convigured Viber bot in your project, just
 * create adapter by implementing this interface.
 *
 * If you have no chatbot in you project, use
 * basic implementation {@see ViberClient}
 */
interface ViberClientInterface
{
    /**
     * @param array|null $eventTypes If null, subscribe to all events. Possible values (message, delivered, seen, failed, subscribed, unsubscribed, conversation_started)
     *
     * @throws ViberApiRequestError
     */
    public function setWebHookUrl(string $url, array $eventTypes = null);

    /**
     *
     * @return StatusCollection
     */
    public function broadcastMessage(
        string $senderName,
        AbstractMessage $message,
        SubscriberIdCollection $subscriberIdCollection
    );

    /**
     * @param SubscriberIdCollection $subscriberIdCollection
     *
     * @return Status
     */
    public function sendMessage(
        string $senderName,
        AbstractMessage $message,
        SubscriberId $subscriberId
    );
}
