<?php

declare(strict_types=1);

namespace Izrajke\RabbitMQ;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class GuzzleClient
{
    /**
     * @param string $url
     * @param array $data
     * @param array $options
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function get(string $url, array $data = [], array $options = []): ResponseInterface
    {
        return $this->makeRequest('GET', $url, $data, $options);
    }

    /**
     * @param string $url
     * @param array $data
     * @param array $options
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function post(string $url, array $data = [], array $options = []): ResponseInterface
    {
        return $this->makeRequest('POST', $url, $data, $options);
    }

    /**
     * @param string $type
     * @param string $url
     * @param array $data
     * @param array $options
     * @return ResponseInterface
     * @throws GuzzleException
     */
    private function makeRequest(string $type, string $url, array $data, array $options): ResponseInterface
    {
        $client = new Client($options);
        return $client->request($type, $url, $data);
    }
}
