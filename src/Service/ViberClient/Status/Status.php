<?php

namespace Sokil\Viber\Notifier\Service\ViberClient\Status;

use Sokil\Viber\Notifier\Entity\SubscriberId;

class Status
{
    const OK = 0; // Success
    const INVALIDURL = 1; // The webhook URL is not valid
    const INVALIDAUTHTOKEN = 2; // The authentication token is not valid
    const BADDATA = 3; // There is an error in the request itself (missing comma, brackets, etc.)
    const MISSINGDATA = 4; // Some mandatory data is missing
    const RECEIVERNOTREGISTERED = 5; // The receiver is not registered to Viber
    const RECEIVERNOTSUBSCRIBED = 6; // The receiver is not subscribed to the account
    const PUBLICACCOUNTBLOCKED = 7; // The account is blocked
    const PUBLICACCOUNTNOTFOUND = 8; // The account associated with the token is not a account.
    const PUBLICACCOUNTSUSPENDED = 9; // The account is suspended
    const WEBHOOKNOTSET = 10; // No webhook was set for the account
    const RECEIVERNOSUITABLEDEVICE = 11; // The receiver is using a device or a Viber version that don’t support accounts
    const TOOMANYREQUESTS = 12; // Rate control breach
    const APIVERSIONNOTSUPPORTED = 13; // Maximum supported account version by all user’s devices is less than the minApiVersion in the message
    const INCOMPATIBLEWITHVERSION = 14; // minApiVersion is not compatible to the message fields
    const PUBLICACCOUNTNOTAUTHORIZED = 15; // The account is not authorized
    const INCHATREPLYMESSAGENOTALLOWED = 16; // Inline message not allowed
    const PUBLICACCOUNTISNOTINLINE = 17; // The account is not inline
    const NOPUBLICCHAT = 18; // Failed to post to public account. The bot is missing a Public Chat interface
    const CANNOTSENDBROADCAST = 19; // Cannot send broadcast message
    const BROADCASTNOTALLOWED = 20; // Attempt to send broadcast message from the bot

    /**
     * @var SubscriberId
     */
    private $subscriberId;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var string
     */
    private $statusMessage;

    /**
     * @param SubscriberId $subscriberId
     * @param int $status
     * @param string $statusMessage
     */
    public function __construct(SubscriberId $subscriberId, $status, $statusMessage)
    {
        if (!is_int($status)) {
            throw new \InvalidArgumentException('Status must be int');
        }

        $this->subscriberId = $subscriberId;
        $this->status = $status;
        $this->statusMessage = $statusMessage;
    }

    /**
     * @return SubscriberId
     */
    public function getSubscriberId()
    {
        return $this->subscriberId;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return string|string
     */
    public function getStatusMessage()
    {
        return $this->statusMessage;
    }

    /**
     * @return bool
     */
    public function isSuccessfull()
    {
        return $this->status === self::OK;
    }
}
