<?php

namespace Sokil\Viber\Notifier\Message\RichMediaMessage\Button;

/**
 * @link https://viber.github.io/docs/tools/keyboards/#replyLogic
 */
class ReplyButton extends AbstractButton
{
    public function getActionType()
    {
        return 'reply';
    }
}