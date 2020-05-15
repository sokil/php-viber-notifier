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
    private $bgColor;

    /**
     * @param string|null $text
     * @param string $actionBody
     * @param string|null $bgColor
     */
    public function __construct($text, $actionBody, $bgColor = null)
    {
        if (is_string($text)) {
            if (mb_strlen($text) > 250) {
                throw new \InvalidArgumentException('Text must be null or string with length less then 250 chars');
            }
        } elseif ($text !== null) {
            throw new \InvalidArgumentException('Text must be null or string with length less then 250 chars');
        }

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