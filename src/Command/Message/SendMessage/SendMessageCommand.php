<?php

namespace Sokil\Viber\Notifier\Command\Message\SendMessage;

use Sokil\Viber\Notifier\Entity\SubscriberIdCollection;

class SendMessageCommand
{
    /**
     * @var string
     */
    private $senderName;

    /**
     * @var string
     */
    private $text;

    /**
     * @var SubscriberIdCollection
     */
    private $subscriberIdCollection;

    /**
     * @param string $senderName
     * @param string $text
     * @param SubscriberIdCollection subscriberIdCollection
     */
    public function __construct(
        $senderName,
        $text,
        SubscriberIdCollection $subscriberIdCollection
    ) {
        if (empty($senderName) || !is_string($senderName)) {
            throw new \InvalidArgumentException('Sender name not specified');
        }

        if (empty($text) || !is_string($text)) {
            throw new \InvalidArgumentException('Text not specified');
        }

        $this->senderName = $senderName;
        $this->text = $text;
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
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return SubscriberIdCollection
     */
    public function getSubscriberIdCollection()
    {
        return $this->subscriberIdCollection;
    }
}