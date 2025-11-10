<?php

namespace Marktic\Pricing\Tests;

use Marktic\Pricing\PricingServiceProvider;
use Mockery;
use Nip\Config\Config;
use Nip\Container\Utility\Container;

/**
 * Class AbstractTest
 */
abstract class TestCase extends \Bytic\Phpqa\PHPUnit\TestCase
{

    protected function loadConfig($data = [])
    {
        $config = config();
        $configNew = new Config(['mkt_pricing' => $data], true);
        Container::container()->set('config', $config->merge($configNew));
    }

    protected function loadConfigFromFixture($name)
    {
        $config = require TEST_FIXTURE_PATH . '/config/' . $name . '.php';
        $this->loadConfig($config);
    }

    protected function loadServiceProvider(): PricingServiceProvider
    {
        $container = Container::container();
        $provider = new PricingServiceProvider();
        $provider->setContainer($container);
        $provider->register();
        return $provider;
    }

    protected function loadFakeTranslator()
    {
        $translator = Mockery::mock('translator');
        $translator->shouldReceive('trans')->andReturnArg(0);

        $container = Container::container();
        $container->set('translator', $translator);
    }
}
