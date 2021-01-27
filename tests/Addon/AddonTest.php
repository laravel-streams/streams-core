<?php

namespace Streams\Core\Tests\Addon;

use Illuminate\Support\Facades\App;
use Streams\Core\Addon\AddonCollection;
use Tests\TestCase;
use Streams\Core\Support\Facades\Streams;

class AddonTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        $addons = App::make(AddonCollection::class);

        $addons->put('test_addon', json_decode(base_path('vendor/streams/core/tests/addons/test-addon/composer.json')));

        Streams::load(base_path('vendor/streams/core/tests/examples.json'));
    }

    public function tearDown(): void
    {
        $this->createApplication();

        $filename = base_path('vendor/streams/core/tests/data/examples/delete_me.json');

        if (file_exists($filename)) {
            unlink($filename);
        }
    }

    public function testRegisters()
    {
        $this->assertJson((string) Streams::entries('testing.examples')->first());
    }
}
