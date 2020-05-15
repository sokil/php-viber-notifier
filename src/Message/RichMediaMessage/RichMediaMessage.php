<?php

namespace Sokil\Viber\Notifier\Message\RichMediaMessage;

use Sokil\Viber\Notifier\Message\AbstractMessage;
use Sokil\Viber\Notifier\Message\RichMediaMessage\Button\AbstractButton;

/**
 * The Rich Media message type allows sending messages
 * with pre-defined layout, including height (rows number), width (columns number), text, images and buttons.
 */
class RichMediaMessage extends AbstractMessage
{
    /**
     * @var AbstractButton[]
     */
    private $buttons;

    /**
     * @param AbstractButton[] $buttons
     */
    public function __construct(array $buttons)
    {
        $this->buttons = $buttons;
    }


    function getMinimalApiVersion()
    {
        return 2;
    }

    function getType()
    {
        return 'rich_media';
    }

    function toApiRequestParams()
    {
        return [
            'rich_media' => [
                "Type" => "rich_media",
                "ButtonsGroupColumns" => 1,
                "ButtonsGroupRows" => 1,
                "BgColor" => "#FFFFFF",
                "Buttons" => array_map(
                    function(AbstractButton $button) {
                        $buttonSettings = [
                            'Columns' => 6,
                            'Rows' => 2,
                            'Text'=> $button->getText(),
                            "ActionType" => $button->getActionType(),
                            "ActionBody" => $button->getActionBody(),
                            'TextHAlign' => 'left',
                        ];

                        if ($button->getBgColor()) {
                            $buttonSettings['BgColor'] = $button->getBgColor();
                        }

                        return $buttonSettings;
                    },
                    $this->buttons
                ),
            ],
        ];
    }

}