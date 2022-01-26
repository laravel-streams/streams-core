<?php

namespace Streams\Core\Tests\Stream\Criteria\Format;

use Tests\TestCase;
use Streams\Core\Support\Facades\Streams;

class TemplateTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        $this->tearDown();

        Streams::register([
            "id" => "testing.examples.tpl",
            "description" => "Used for testing.",

            "source" => [
                "path" => "vendor/streams/core/tests/data/examples",
                "format" => "tpl"
            ],
        ]);
    }

    public function testCanEncodeAndDecode()
    {
        $entry = Streams::entries('testing.examples.tpl')->first();
        $blank = Streams::entries('testing.examples.tpl')->find('second');

        $this->assertEquals('First TPL Example', $entry->name);
        $this->assertEquals("Test TPL Body", trim($entry->template, "\n"));
        $this->assertEquals("TPL Body Only", trim($blank->template, "\n"));

        Streams::entries('testing.examples.tpl')->create([
            'id' => 'third',
            'name' => 'Third TPL Example',
        ]);

        $this->assertEquals(3, Streams::entries('testing.examples.tpl')->count());
    }

    public function tearDown(): void
    {
        $this->createApplication();

        $filename = base_path('vendor/streams/core/tests/data/examples/third.tpl');

        if (file_exists($filename)) {
            unlink($filename);
        }
    }
}
