<?php

namespace Streams\Core\Tests\Entry;

use Tests\TestCase;
use Streams\Core\Entry\Entry;
use Streams\Core\Stream\Stream;
use Streams\Core\Support\Facades\Streams;

class EntryTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

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

    public function test_accessibility_interfaces()
    {
        $this->assertIsArray(Streams::entries('testing.examples')->first()->toArray());
        $this->assertJson(Streams::entries('testing.examples')->first()->toJson());
        $this->assertJson((string) Streams::entries('testing.examples')->first());
        $this->assertJson(json_encode(Streams::entries('testing.examples')->first()));
    }

    public function test_can_return_its_stream()
    {
        $entry = Streams::entries('testing.examples')->first();

        $this->assertInstanceOf(Stream::class, $entry->stream());
    }

    public function testCRUD()
    {
        $entry = new Entry([
            'id' => 'delete_me',
            'stream' => 'testing.examples',
            'name' => 'This message will self-destruct.',
        ]);

        $result = $entry->save();

        $this->assertTrue($result);


        $entry = Streams::entries('testing.examples')->find('delete_me');

        $this->assertInstanceOf(Entry::class, $entry);


        $entry->name = 'Mo';

        $entry->save();

        $entry = Streams::entries('testing.examples')->find('delete_me');
        
        $this->assertEquals('Mo', $entry->name);
        $this->assertFalse($entry->validator()->passes());

        $result = $entry->delete();

        $this->assertTrue($result);

        $count = Streams::entries('testing.examples')
            ->where('id', 'delete_me')
            ->count();

        $this->assertEquals(0, $count);
    }
}
