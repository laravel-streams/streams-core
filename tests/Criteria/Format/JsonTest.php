<?php

namespace Streams\Core\Tests\Stream\Criteria\Format;

use Tests\TestCase;
use Streams\Core\Support\Facades\Streams;

class JsonTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::register([
            "id" => "testing.examples.json",
            "description" => "Used for testing.",

            "source" => [
                "path" => "vendor/streams/core/tests/data/examples",
                "format" => "json"
            ],
        ]);
    }

    public function testCanEncodeAndDecode()
    {
        Streams::entries('testing.examples.json')->create([
            'id' => 'third',
            'name' => 'Third Example',
        ]);

        $this->assertEquals('Third Example', Streams::entries('testing.examples.json')->find('third')->name);
    }

    public function tearDown(): void
    {
        $this->createApplication();

        $filename = base_path('vendor/streams/core/tests/data/examples/third.json');

        if (file_exists($filename)) {
            unlink($filename);
        }
    }
}
