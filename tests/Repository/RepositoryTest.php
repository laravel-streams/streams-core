<?php

namespace Streams\Core\Tests\Stream\Repository;

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

    public function testCanReturnResults()
    {
        $all = Streams::repository('testing.examples')->all();
        $first = Streams::repository('testing.examples')->find('first');
        $both = Streams::repository('testing.examples')->findAll(['first', 'second']);
        $second = Streams::repository('testing.examples')->findBy('name', 'Second Example');
        $examples = Streams::repository('testing.examples')->findAllWhere('name', 'LIKE', '%Example%');

        $this->assertEquals(2, $all->count());
        $this->assertEquals(2, $both->count());
        $this->assertEquals(2, $examples->count());

        $this->assertEquals("First Example", $first->name);
        $this->assertEquals("Second Example", $second->name);
    }

    public function testCanCreateSaveAndDelete()
    {
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

    public function tearDown(): void
    {
        $filename = base_path('vendor/streams/core/tests/data/examples/third.json');

        if (file_exists($filename)) {
            unlink($filename);
        }
    }
}
