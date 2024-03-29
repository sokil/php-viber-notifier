<?php

declare(strict_types=1);

namespace Sokil\Viber\Notifier\Command\Message\SendMessage;

use Sokil\Viber\Notifier\Entity\SubscriberIdCollection;
use Sokil\Viber\Notifier\Message\AbstractMessage;

class SendMessageCommand
{
    /**
     * @var string
     */
    private $senderName;

    /**
     * @var AbstractMessage
     */
    private $message;

    /**
     * @var SubscriberIdCollection
     */
    private $subscriberIdCollection;

    /**
     * @param SubscriberIdCollection subscriberIdCollection
     */
    public function __construct(
        string $senderName,
        AbstractMessage $message,
        SubscriberIdCollection $subscriberIdCollection
    ) {
        if (empty($senderName) || !is_string($senderName)) {
            throw new \InvalidArgumentException('Sender name not specified');
        }

        if (count($subscriberIdCollection) === 0) {
            throw new \InvalidArgumentException('Empty sender list specified');
        }

        $this->senderName = $senderName;
        $this->message = $message;
        $this->subscriberIdCollection = $subscriberIdCollection;
    }

    /**
     * @return string
     */
    public function getSenderName()
    {
        return $this->senderName;
    }

    /**
     * @return AbstractMessage
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return SubscriberIdCollection
     */
    public function getSubscriberIdCollection()
    {
        return $this->subscriberIdCollection;
    }
}
