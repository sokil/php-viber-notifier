<?php

namespace Sokil\Viber\Notifier\Message;

class TextMessage extends AbstractMessage
{
    /**
     * @var string
     */
    private $text;

    /**
     * @param string $test
     */
    public function __construct($test)
    {
        if (!is_string($test) || empty($test)) {
            throw new \InvalidArgumentException('Message not specified');
        }

        $this->text = $test;
    }

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
    function getType()
    {
        return 'text';
    }

    /**
     * @return array
     */
    function toApiRequestParams()
    {
        return [
            'text' => $this->text,
        ];
    }


}