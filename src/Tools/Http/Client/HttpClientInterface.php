<?php

declare(strict_types=1);

namespace Sokil\Viber\Notifier\Tools\Http\Client;

interface HttpClientInterface
{
    /**
     * @param array $headers
     * @param array $body
     *
     * @return array
     */
    public function request(string $uri, array $headers, array $body);
}
