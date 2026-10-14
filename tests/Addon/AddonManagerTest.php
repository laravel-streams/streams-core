<?php

namespace Streams\Core\Tests\Addon;

use Streams\Core\Addon\Addon;
use Illuminate\Support\Collection;
use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Addons;

class AddonManagerTest extends CoreTestCase
{
    public function test_it_loads_an_addon_by_path()
    {
        Addons::load('vendor/streams/testing');

        $addon = Addons::make('streams/testing');

        $this->assertInstanceOf(Addon::class, $addon);
    }

    public function test_it_returns_registered_addons()
    {
        $addons = Addons::collection();

        $this->assertInstanceOf(Collection::class, $addons);
    }

    public function test_it_returns_provisioning_addons()
    {
        $this->assertTrue(Addons::providing('testing.*')->isEmpty());
    }

    public function test_it_registers_an_addon_from_a_name_and_paths()
    {
        $paths = [
            'path' => '/tmp/my-addon',
            'assets' => '/tmp/my-addon/resources/public',
        ];

        $addon = Addons::register('my-addon', $paths);

        $this->assertInstanceOf(Addon::class, $addon);
        $this->assertSame('my-addon', $addon->name);
        $this->assertSame('/tmp/my-addon', $addon->path);
        $this->assertSame('/tmp/my-addon/resources/public', $addon->assets);
        $this->assertSame($paths, $addon->paths);
        $this->assertSame('my-addon', Addons::make('my-addon')->name);
    }

    public function test_discovery_accepts_extra_streams_addon_without_the_composer_type()
    {
        $root = base_path('vendor/streams-core-registry-test');

        $packages = [
            'streams-core-registry-test/extra-addon' => [
                'name' => 'streams-core-registry-test/extra-addon',
                'type' => 'library',
                'extra' => [
                    'streams' => [
                        'addon' => true,
                    ],
                ],
            ],
            'streams-core-registry-test/typed-addon' => [
                'name' => 'streams-core-registry-test/typed-addon',
                'type' => 'streams-addon',
            ],
            'streams-core-registry-test/plain-library' => [
                'name' => 'streams-core-registry-test/plain-library',
                'type' => 'library',
            ],
        ];

        $this->assertDirectoryDoesNotExist($root);

        try {
            foreach ($packages as $name => $package) {
                $directory = base_path('vendor/'.$name);

                if (! is_dir($directory) && ! mkdir($directory, 0777, true) && ! is_dir($directory)) {
                    $this->fail("Could not create {$directory}.");
                }

                file_put_contents($directory.'/composer.json', json_encode($package));
            }

            $this->app->instance('composer.json', []);
            $this->app->instance('composer.lock', [
                'packages' => array_values($packages),
                'packages-dev' => [],
            ]);

            $provider = $this->app->getProvider(\Streams\Core\StreamsServiceProvider::class);
            $method = new \ReflectionMethod($provider, 'registerAddons');
            $method->setAccessible(true);
            $method->invoke($provider);

            $this->assertTrue(Addons::collection()->has('streams-core-registry-test/extra-addon'));
            $this->assertTrue(Addons::collection()->has('streams-core-registry-test/typed-addon'));
            $this->assertFalse(Addons::collection()->has('streams-core-registry-test/plain-library'));
        } finally {
            if (is_dir($root)) {
                \Illuminate\Support\Facades\File::deleteDirectory($root);
            }
        }
    }
}
