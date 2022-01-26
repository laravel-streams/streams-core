<?php

namespace Streams\Core\Tests\Stream\Criteria\Format;

use Tests\TestCase;
use Streams\Core\Support\Facades\Streams;

class MarkdownTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::register([
            "id" => "testing.examples.md",
            "description" => "Used for testing.",

            "source" => [
                "path" => "vendor/streams/core/tests/data/examples",
                "format" => "md"
            ],
        ]);
    }

    public function testCanEncodeAndDecode()
    {
        $entry = Streams::entries('testing.examples.md')->first();
        $blank = Streams::entries('testing.examples.md')->find('second');

        $this->assertEquals('First MD Example', $entry->name);
        $this->assertEquals("Test Body", trim($entry->body, "\n"));
        $this->assertEquals("Body Only", trim($blank->body, "\n"));

        Streams::entries('testing.examples.md')->create([
            'id' => 'third',
            'name' => 'Third MD Example',
        ]);

        $this->assertEquals(3, Streams::entries('testing.examples.md')->count());
    }

    public function tearDown(): void
    {
        $this->createApplication();

        $filename = base_path('vendor/streams/core/tests/data/examples/third.md');

        if (file_exists($filename)) {
            unlink($filename);
        }
    }
}
