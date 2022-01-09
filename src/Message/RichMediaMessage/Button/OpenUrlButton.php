<?php

declare(strict_types=1);

namespace Sokil\Viber\Notifier\Message\RichMediaMessage\Button;

/**
 * @link https://viber.github.io/docs/tools/keyboards/#replyLogic
 *
 * The value of ActionBody is sent as a text message to account (via message event)
 * The value of ActionBody is opened in the browser
 * The value of ActionBody appears in the chat thread as message from the user.
 */
class OpenUrlButton extends AbstractButton
{
    public function getActionType()
    {
        return 'open-url';
    }
}
