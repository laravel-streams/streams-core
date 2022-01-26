<?php

namespace Streams\Core\Tests\Stream\Criteria\Format;

use Tests\TestCase;
use Streams\Core\Support\Facades\Streams;

class PhpTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::register([
            "id" => "testing.examples.php",
            "description" => "Used for testing.",

            "source" => [
                "path" => "vendor/streams/core/tests/data/examples",
                "format" => "php"
            ],
        ]);
    }

    public function testCanEncodeAndDecode()
    {
        $entry = Streams::entries('testing.examples.php')->first();
        $blank = Streams::entries('testing.examples.php')->find('second');

        $this->assertEquals('First Example', $entry->name);

        Streams::entries('testing.examples.php')->create([
            'id' => 'third',
            'name' => 'Third Example',
        ]);

        $this->assertEquals(3, Streams::entries('testing.examples.php')->count());
    }

    public function tearDown(): void
    {
        $filename = base_path('vendor/streams/core/tests/data/examples/third.php');

        if (file_exists($filename)) {
            unlink($filename);
        }
    }
}
