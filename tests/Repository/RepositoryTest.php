<?php

namespace Streams\Core\Tests\Stream\Repository;

use Streams\Core\Entry\Entry;
use Streams\Core\Stream\Stream;
use Tests\TestCase;
use Streams\Core\Support\Facades\Streams;

class RepositoryTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/examples.json'));

        $filename = base_path('vendor/streams/core/tests/data/examples/third.json');

        if (file_exists($filename)) {
            unlink($filename);
        }
    }

    public function tearDown(): void
    {
        $filename = base_path('vendor/streams/core/tests/data/examples/third.json');

        if (file_exists($filename)) {
            unlink($filename);
        }
    }

    public function test_can_return_all_results()
    {
        $all = Streams::repository('testing.examples')->all();
        
        $this->assertEquals(2, $all->count());
    }

    public function test_can_find_result_by_id()
    {
        $first = Streams::repository('testing.examples')->find('first');
        
        $this->assertEquals("First Example", $first->name);
    }

    public function test_can_find_all_results_matching_ids()
    {
        $both = Streams::repository('testing.examples')->findAll(['first', 'second']);

        $this->assertEquals(2, $both->count());
    }

    public function test_can_find_by_specified_value()
    {
        $second = Streams::repository('testing.examples')->findBy('name', 'Second Example');

        $this->assertEquals("Second Example", $second->name);
    }

    public function test_can_find_all_by_specified_value()
    {
        $examples = Streams::repository('testing.examples')->findAllWhere('name', 'LIKE', '%Example%');

        $this->assertEquals(2, $examples->count());
    }

    public function test_can_create_and_delete_entries()
    {
        $this->tearDown();

        $entry = Streams::repository('testing.examples')->create([
            'id' => 'third',
            'name' => 'Third Example',
        ]);

        $this->assertEquals(3, Streams::entries('testing.examples')->count());
        

        $entry->name = 'THIRD EXAMPLE!';
        
        Streams::repository('testing.examples')->save($entry);
        
        $updated = Streams::repository('testing.examples')->find('third');
        
        $this->assertEquals('THIRD EXAMPLE!', $updated->name);


        Streams::repository('testing.examples')->delete($entry);

        $this->assertEquals(2, Streams::entries('testing.examples')->count());
    }

    public function test_can_create_new_instance()
    {
        $entry = Streams::repository('testing.examples')->newInstance([
            'id' => 'example',
            'name' => 'Example',
        ]);

        $this->assertInstanceOf(Entry::class, $entry);
        $this->assertInstanceOf(Stream::class, $entry->stream);
    }
}
