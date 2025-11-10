<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use Nip\Cache\Stores\Repository;
use Nip\Config\Config;
use Nip\Container\Container;
use Nip\Inflector\Inflector;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

define('PROJECT_BASE_PATH', __DIR__ . '/..');
define('TEST_BASE_PATH', __DIR__);
define('TEST_FIXTURE_PATH', __DIR__ . DIRECTORY_SEPARATOR . 'fixtures');

$container = new Container();
Container::setInstance($container);

$container->set('inflector', Inflector::instance());
$container->set('config', new Config([], true));


$adapter = new FilesystemAdapter('', 600, TEST_FIXTURE_PATH . '/cache');
$store = new Repository($adapter);
$store->clear();
$container->set('cache.store', $store);
