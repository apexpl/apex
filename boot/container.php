<?php

use Apex\Svc\Di;
use League\Flysystem\Filesystem;
use Apex\Db\Interfaces\DbInterface;
use Apex\Cluster\Interfaces\BrokerInterface;
use Apex\App\Interfaces\RouterInterface;
use Apex\Mercury\Interfaces\{EmailerInterface, SmsClientInterface, FirebaseClientInterface, WsClientInterface};
use Psr\Log\LoggerInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\SimpleCache\CacheInterface;
use Psr\Http\Client\ClientInterface as HttpClientInterface;
use Apex\Container\Interfaces\ApexContainerInterface;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Symfony\Component\Cache\Psr16Cache;

/**
 * This file allows you to switch out the implementations used for various 
 * PSR compliant and other services.  You may change the implementations below to 
 * anything you wish as long as it still implements the appropriate interface.
 */
return [

    /**
     * SQL database driver.  This can be changed to either PostgreSQL or SQLite, 
     * but must be changed before installation.
     */
    DbInterface::class => \Apex\Db\Drivers\mySQL\mySQL::class, 

    /**
     * PSR-18 compliant HTTP client.
     */
    HttpClientInterface::class => \GuzzleHttp\Client::class,

    /**
     * E-mailer.  If preferred, PhpMailer and Symfony Mailer adapters are available within 
     * the Apex\App\Adapters\Email namespace.  See documentation for details.
     */
    EmailerInterface::class => \Apex\Mercury\Email\Emailer::class,

    /**
     * Instance of league/filesystem for storage of files and content.  Defaults to local storage of /storage/ directory, 
     * although can be easily changed to AWS S3, DigitalOcean, and others.
     */
    Filesystem::class => function() { 
        return \Apex\Storage\Storage::init('local', ['dir' => SITE_PATH . '/storage']);
    },

    /**
     * HTTP router that is used, for cases where you prefer to implement your own router.
     */ 
    RouterInterface::class => \Apex\App\Base\Router\Router::class,

    /**
     * PSR-6 compliant cache.  Is set to null if caching within configuration is disabled.
     */
    CacheItemPoolInterface::class => [\Symfony\Component\Cache\Adapter\RedisAdapter::class, ['namespace' => 'cache']],
    'syrus.cache_ttl' => 300, 

    /**
     * PSR-16 compliant cache.  Is set to null if caching within configuration is disabled.
     */
    cacheInterface::class => function() {
        $psr6cache = Di::get(CacheItemPoolInterface::class);
        return new Psr16Cache($psr6cache);
    },

    /**
     * Generally only needs to be changed if you wish to enable horizontal scaling via RabbitMQ 
     * or other message brokers.  Please refer to documentation for details.
     */
    BrokerInterface::class => Apex\Cluster\Brokers\Local::class, 
    'cluster.timeout_seconds' => 3,  

    /**
     * PSR-3 compliant logger
     */
    LoggerInterface::class => function() { 
        $logdir = __DIR__ . '/../storage/logs';
        return new Logger('app', [
            new StreamHandler($logdir . '/debug.log', Logger::DEBUG), 
            new StreamHandler($logdir . '/app.log', Logger::INFO), 
            new StreamHandler($logdir . '/error.log', Logger::ERROR) 
        ]);
    }, 

    /**
     * Messaging implements for SMS client, Firebase, and web socket client.
     */
    SmsClientInterface::class => \Apex\Mercury\SMS\Nexmo::class,
    FirebaseClientInterface::class => \Apex\Mercury\Firebase\Firebase::class,
    WsClientInterface::class => \Apex\Mercury\Websocket\WsClient::class,

    /**
     * Cookie options array.  ~domain~ is replaced with the 
     * domain name in your settings.
     */
    'armor.cookie_prefix' => 'armor_', 
    'armor.cookie' => [
        'path' => '/', 
        'domain' => '~domain~',
        'secure' => true, 
        'httponly' => false,
        'samesite' => 'strict'
    ],

    /**
     * Dependency injection container, and should generally never be changed.  Must be a closure, and implement the 
     * ApexContainerInterface.  Please see documentation for details.
     */
    ApexContainerInterface::class => function() { 
        return new \Apex\Container\Container(use_attributes: true);
    }

];

