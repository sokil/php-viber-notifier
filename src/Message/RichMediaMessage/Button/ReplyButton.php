<?php

namespace Sokil\Viber\Notifier\Message\RichMediaMessage\Button;

/**
 * @link https://viber.github.io/docs/tools/keyboards/#replyLogic
 *
 * The value of ActionBody is sent as a text message to account (via message event)
 * The value of text appears in the chat thread as message from the user.
 */
class ReplyButton extends AbstractButton
{
    public function getActionType()
    {
        return 'reply';
    }
}