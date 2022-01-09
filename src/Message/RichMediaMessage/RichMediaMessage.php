<?php

declare(strict_types=1);

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
     * @var int
     */
    private $buttonsGroupColumns = 6;

    /**
     * @var int
     */
    private $buttonsGroupRows = 7;

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

    /**
     *
     * @return self
     */
    public function setButtonsGroupColumns(int $buttonsGroupColumns)
    {
        $this->buttonsGroupColumns = $buttonsGroupColumns;

        return $this;
    }

    /**
     *
     * @return self
     */
    public function setButtonsGroupRows(int $buttonsGroupRows)
    {
        $this->buttonsGroupRows = $buttonsGroupRows;

        return $this;
    }

    function toApiRequestParams()
    {
        return [
            'rich_media' => [
                "Type" => "rich_media",
                "ButtonsGroupColumns" => $this->buttonsGroupColumns,
                "ButtonsGroupRows" => $this->buttonsGroupRows,
                "BgColor" => "#FFFFFF",
                "Buttons" => array_map(
                    function (AbstractButton $button) {
                        $buttonSettings = [
                            'Columns' => $button->getColumns(),
                            'Rows' => $button->getRows(),
                            'Text' => $button->getText(),
                            'Silent' => $button->isSilent(),
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
