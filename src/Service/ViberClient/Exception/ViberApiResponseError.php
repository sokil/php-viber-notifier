<?php

declare(strict_types=1);

namespace Sokil\Viber\Notifier\Service\ViberClient\Exception;

class ViberApiResponseError extends \Exception
{
    /**
     * @var array
     */
    private $response;

    /**
     * @param array $response
     */
    public function setResponse(array $response): void
    {
        $this->response = $response;
    }
}
