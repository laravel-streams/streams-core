<?php

namespace Streams\Core\Tests\Addon;

use Tests\TestCase;
use Streams\Core\Addon\Addon;
use Illuminate\Support\Facades\App;
use Streams\Core\Addon\AddonCollection;
use Streams\Core\Support\Facades\Addons;
use Streams\Core\Support\Facades\Streams;

class AddonTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Addons::load(base_path('vendor/streams/core/tests/addons/test-addon'));
    }

    public function testRegisters()
    {
        $this->assertInstanceOf(Addon::class, Addons::make('streams/test-addon'));
    }

    public function testArrayable()
    {
        $this->assertEquals([
            'name',
            'path',
            'composer',
            'enabled',
            'listeners',
            'observers',
        ], array_keys(Addons::make('streams/test-addon')->toArray()));
    }

    public function testJsonable()
    {
        $this->assertEquals([
            'name',
            'path',
            'composer',
            'enabled',
            'listeners',
            'observers',
        ], array_keys(json_decode(Addons::make('streams/test-addon')->toJson(), true)));
    }
}
