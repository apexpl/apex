<?php

use Apex\Svc\Filesystem;
use Apex\Db\Interfaces\DbInterface;
use Apex\Cluster\Interfaces\BrokerInterface;
use Apex\App\Interfaces\RouterInterface;
use Psr\Log\LoggerInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Http\Client\ClientInterface as HttpClientInterface;
use Apex\Container\Interfaces\ApexContainerInterface;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

return [
    DbInterface::class => \Apex\Db\Drivers\mySQL\mySQL::class, 
    CacheItemPoolInterface::class => null, 
    HttpClientInterface::class => function () { return new \GuzzleHttp\Client(['verify' => false]); }, 
    BrokerInterface::class => Apex\Cluster\Brokers\Local::class, 
    Filesystem::class => [Storage::class, [
        'adapter' => 'local', 
        'credentials' => ['dir' => __DIR__ . '/storage']
    ]],
    RouterInterface::class => \Apex\App\Base\Router\Router::class,

    LoggerInterface::class => function() { 
        $logdir = __DIR__ . '/../storage/logs';
        return new Logger('app', [
            new StreamHandler($logdir . '/debug.log', Logger::DEBUG), 
            new StreamHandler($logdir . '/app.log', Logger::INFO), 
            new StreamHandler($logdir . '/error.log', Logger::ERROR) 
        ]);
    }, 

    ApexContainerInterface::class => function() { 
        return new \Apex\Container\Container(use_attributes: true);
    }, 

    'syrus.cache_ttl' => 300, 
    'cluster.timeout_seconds' => 3,  
    'armor.cookie_prefix' => 'armor_', 
    'armor.cookie' => [
        'path' => '/', 
        'domain' => '127.0.0.1', 
        'secure' => false, 
        'httponly' => false
        //'samesite' => 'strict'
    ] 
];


