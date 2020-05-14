<?php

namespace Sokil\Viber\Notifier\Message\RichMediaMessage\Button;

/**
 *  @link https://viber.github.io/docs/tools/keyboards/
 */
abstract class AbstractButton
{
    /**
     * @var string
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
    private $bgColor;

    /**
     * @param string $text
     * @param string $actionBody
     * @param string|null $bgColor
     */
    public function __construct($text, $actionBody, $bgColor = null)
    {
        $this->text = $text;
        $this->actionBody = $actionBody;
        $this->bgColor = $bgColor;
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
     * @return string|null
     */
    public function getBgColor()
    {
        return $this->bgColor;
    }
}