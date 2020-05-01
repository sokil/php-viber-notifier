<?php

namespace Sokil\Viber\Notifier\Tools\Http\Client;

interface HttpClientInterface
{
    /**
     * @param string $uri
     * @param array $headers
     * @param array $body
     *
     * @return array
     */
    public function request($uri, array $headers, array $body);
}