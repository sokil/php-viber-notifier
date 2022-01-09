<?php

declare(strict_types=1);

namespace Sokil\Viber\Notifier\Message\RichMediaMessage\Button;

/**
 * @link https://viber.github.io/docs/tools/keyboards/#replyLogic
 */
class InformativeButton extends AbstractButton
{
    public function getActionType()
    {
        return 'none';
    }
}
