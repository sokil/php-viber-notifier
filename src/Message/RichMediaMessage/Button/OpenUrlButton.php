<?php

namespace Sokil\Viber\Notifier\Message\RichMediaMessage\Button;

class OpenUrlButton extends AbstractButton
{
    public function getActionType()
    {
        return 'open-url';
    }
}