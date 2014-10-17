<?php namespace Streams\Platform\Addon\Extension;

class ExtensionServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    public static function setUpBeforeClass()
    {
        $provider = new \Streams\Platform\Provider\AddonServiceProvider(app());

        $provider->register();
    }

    public function testItRegistersExtensionsToContainer()
    {
        $provider = new ExtensionServiceProvider(app());

        $provider->addLocation(__DIR__ . '/../../../../tests/addons');

        $provider->register();

        $expected = 'Streams\Platform\Addon\Extension\ExtensionPresenter';
        $actual   = app('streams.extension.testable_module_test_extension');

        $this->assertInstanceOf($expected, $actual);
    }

    public function testItPushesExtensionsToCollection()
    {
        $provider = new ExtensionServiceProvider(app());

        $provider->addLocation(__DIR__ . '/../../../../tests/addons');

        $provider->register();

        $expected = 'Streams\Platform\Addon\Extension\ExtensionPresenter';
        $actual   = app('streams.extensions')->findBySlug('testable_module_test_extension');

        $this->assertInstanceOf($expected, $actual);
    }
}
 