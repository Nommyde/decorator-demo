<?php

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Nommyde\AcmeDataProvider;
use Nommyde\CachingDataProviderDecorator;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

require_once __DIR__ . '/vendor/autoload.php';

$dataProvider = new AcmeDataProvider('localhost', 'usr', 'pwd');

$cache = new FilesystemAdapter('app', 0, __DIR__ . '/cache');
$logger = new Logger('app', [new StreamHandler('php://output')]);

$cachingDataProvider = new CachingDataProviderDecorator($dataProvider, $cache, $logger);

print_r($cachingDataProvider->getData(['bla' => 'blo']));
