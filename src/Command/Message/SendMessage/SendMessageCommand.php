<?php

namespace Sokil\Viber\Notifier\Command\Message\SendMessage;

use Sokil\Viber\Notifier\Entity\Role;

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
     * @var Role
     */
    private $role;

    /**
     * @param string $senderName
     * @param string $text
     * @param Role|null $role
     */
    public function __construct(
        $senderName,
        $text,
        Role $role = null
    ) {
        if (empty($senderName)) {
            throw new \InvalidArgumentException('Sender name not specified');
        }

        if (empty($text)) {
            throw new \InvalidArgumentException('Text not specified');
        }

        $this->senderName = $senderName;
        $this->text = $text;
        $this->role = $role;
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
     * @return Role
     */
    public function getRole()
    {
        return $this->role;
    }
}