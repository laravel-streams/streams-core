<?php

namespace Streams\Core\Tests\Stream\Criteria\Format;

use Tests\TestCase;
use Streams\Core\Support\Facades\Streams;

class YamlTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::register([
            "id" => "testing.examples.yaml",
            "description" => "Used for testing.",

            "source" => [
                "path" => "vendor/streams/core/tests/data/examples",
                "format" => "yaml"
            ],
        ]);
    }

    public function testCanEncodeAndDecode()
    {
        $entry = Streams::entries('testing.examples.yaml')->first();

        $this->assertEquals('First YAML Example', $entry->name);
        
        Streams::entries('testing.examples.yaml')->create([
            'id' => 'third',
            'name' => 'Third YAML Example',
        ]);

        $this->assertEquals(3, Streams::entries('testing.examples.yaml')->count());
    }

    public function tearDown(): void
    {
        $this->createApplication();

        $filename = base_path('vendor/streams/core/tests/data/examples/third.yaml');

        if (file_exists($filename)) {
            unlink($filename);
        }
    }
}
