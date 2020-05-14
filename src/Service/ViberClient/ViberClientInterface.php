<?php

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
     * @param string $url
     *
     * @throws ViberApiRequestError
     */
    public function setWebHookUrl($url);

    /**
     * @param string $senderName
     * @param AbstractMessage $message
     * @param SubscriberIdCollection $subscriberIdCollection
     *
     * @return StatusCollection
     */
    public function broadcastMessage(
        $senderName,
        AbstractMessage $message,
        SubscriberIdCollection $subscriberIdCollection
    );

    /**
     * @param string $senderName
     * @param AbstractMessage $message
     * @param SubscriberIdCollection $subscriberIdCollection
     *
     * @return Status
     */
    public function sendMessage(
        $senderName,
        AbstractMessage $message,
        SubscriberId $subscriberId
    );
}