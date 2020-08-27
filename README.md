RabbitMQ Client for exchange message count 
===================

For license information check the [LICENSE](LICENSE)-file.

Installation
------------

```
composer require izrajke/rabbit-mq-exchange-counter
```

Example
-------

```php
    $host = '127.0.0.1';
    $user = 'guest';
    $password = 'guest';

    $client = new \Izrajke\RabbitMQ\RabbitMQClient($host, $user, $password);
    $data = $client->getExchangeCounter(['first-ex-dev', 'second-ex-dev', 'third-ex-dev']);

    // Output
    /**
        array(3) {
            'first-ex-dev' => 5
            'second-ex-dev' => 0
            'third-ex-dev' => 1
        }
    */
```
