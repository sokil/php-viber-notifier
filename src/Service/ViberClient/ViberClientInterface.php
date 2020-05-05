<?php

namespace Sokil\Viber\Notifier\Service\ViberClient;

use Sokil\Viber\Notifier\Entity\SubscriberIdCollection;
use Sokil\Viber\Notifier\Service\ViberClient\Exception\CanNotSetWebHookException;

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
     * @throws CanNotSetWebHookException
     */
    public function setWebHookUrl($url);

    /**
     * @param string $senderName
     * @param string $message
     * @param SubscriberIdCollection $subscriberIdCollection
     *
     * @return bool[]
     */
    public function broadcastMessage($senderName, $message, SubscriberIdCollection $subscriberIdCollection);
}