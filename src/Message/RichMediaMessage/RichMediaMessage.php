<?php

namespace Sokil\Viber\Notifier\Message\RichMediaMessage;

use Sokil\Viber\Notifier\Message\AbstractMessage;

/**
 * The Rich Media message type allows sending messages
 * with pre-defined layout, including height (rows number), width (columns number), text, images and buttons.
 */
class RichMediaMessage extends AbstractMessage
{
    function getType()
    {
        return 'rich_media';
    }

    function toApiRequestParams()
    {
        return [
            'rich_media' => [
                "Type" => "rich_media",
                "ButtonsGroupColumns" => 6,
                "ButtonsGroupRows" => 3,
                "BgColor" => "#FFFFFF",
                "Buttons" => [
                    [
                        'Columns' => 6,
                        'Rows' => 2,
                        'Text'=> "Message text",
                        "ActionType" => "reply",
                        "ActionBody" => "Key message",
                    ],
                    [
                        'Columns' => 6,
                        'Rows' => 1,
                        'Text'=> "Press key",
                        "ActionType" => "reply",
                        "ActionBody" => "Key message",
                    ],
                ],
            ],
        ];
    }

}