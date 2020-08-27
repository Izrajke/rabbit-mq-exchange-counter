<?php

declare(strict_types=1);

namespace Izrajke\RabbitMQ;

use GuzzleHttp\Exception\GuzzleException;
use RuntimeException;

class RabbitMQClient
{
    private const DEFAULT_PORT = 15672;
    private const DEFAULT_VHOST = '/';

    private $host;
    private $user;
    private $password;
    private $isTest;
    private $port;
    private $vhost;
    private $httpClient;

    public function __construct(
        string $host,
        string $user,
        string $password,
        bool $isTest = true,
        int $port = self::DEFAULT_PORT,
        string $vhost = self::DEFAULT_VHOST
    ) {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->isTest = $isTest;
        $this->port = $port;
        $this->vhost = $vhost;

        $this->httpClient = new GuzzleClient();
    }

    public function getExchangeCounter(array $exchanges): array
    {
        $data = [];
        foreach ($exchanges as $exchange) {
            try {
                $json = $this->getJson($exchange);
                $data[$exchange] = $json['messages_delayed'] ?? 0;
            } catch (GuzzleException | RuntimeException $exception) {
                $data[$exchange] = 0;
            }
        }
        return $data;
    }

    /**
     * @param string $exchange
     * @return mixed
     * @throws GuzzleException
     * @throws RuntimeException
     */
    private function getJson(string $exchange): array
    {
        $path = sprintf('exchanges/%s/%s', urlencode($this->vhost), $exchange);
        $url = $this->getUrl($path);
        $response = $this->httpClient->get($url, [], ['auth' => [$this->user, $this->password]]);
        $content = $response->getBody()->getContents();
        return json_decode($content, true);
    }

    private function getUrl(string $path): string
    {
        $scheme = $this->isTest ? 'http' : 'https';
        return sprintf('%s://%s:%s/api/%s', $scheme, $this->host, $this->port, $path);
    }
}
