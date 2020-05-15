<?php

namespace Sokil\Viber\Notifier\Message\RichMediaMessage\Button;

/**
 *  @link https://viber.github.io/docs/tools/keyboards/
 */
abstract class AbstractButton
{
    /**
     * 	Text to be displayed on the button. Can contain some HTML tags.
     * Valid and allowed HTML tags Max 250 characters.
     * If the text is too long to display on the button it will be cropped and ended with “…”
     *
     * @var string|null
     */
    private $text;

    /**
     * @var string
     */
    private $actionBody;

    /**
     * Background color of button
     * Valid color HEX value
     * @var string|null
     */
    private $bgColor = '#FFFFFF';

    /**
     * @var bool
     */
    private $isSilent = false;

    /**
     * @var int
     */
    private $columns = 6;

    /**
     * @var int
     */
    private $rows = 1;

    /**
     * @param string|null $text
     * @param string $actionBody
     */
    public function __construct(
        $text,
        $actionBody
    ) {
        if (is_string($text)) {
            if (mb_strlen($text) > 250) {
                throw new \InvalidArgumentException('Text must be null or string with length less then 250 chars');
            }
        } elseif ($text !== null) {
            throw new \InvalidArgumentException('Text must be null or string with length less then 250 chars');
        }

        $this->text = $text;
        $this->actionBody = $actionBody;
    }

    abstract public function getActionType();

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getActionBody()
    {
        return $this->actionBody;
    }

    /**
     * @return int
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * @param int $columns
     */
    public function setColumns($columns)
    {
        if (!is_numeric($columns) || $columns < 1 || $columns > 6) {
            throw new \InvalidArgumentException('Rows count may be from 1 to 6');
        }

        $this->columns = $columns;
    }

    /**
     * @return int
     */
    public function getRows()
    {
        return $this->rows;
    }

    /**
     * @param int $rows
     */
    public function setRows($rows)
    {
        if (!is_numeric($rows) || $rows < 1 || $rows > 2) {
            throw new \InvalidArgumentException('Rows count may be 1 or 2');
        }

        $this->rows = $rows;
    }

    /**
     * @param bool $isSilent
     */
    public function setSilent($isSilent)
    {
        $this->isSilent = $isSilent;
    }

    /**
     * @return bool
     */
    public function isSilent()
    {
        return $this->isSilent;
    }

    /**
     * @param string $bgColor
     */
    public function setBgColor($bgColor)
    {
        $this->bgColor = $bgColor;
    }

    /**
     * @return string|null
     */
    public function getBgColor()
    {
        return $this->bgColor;
    }
}