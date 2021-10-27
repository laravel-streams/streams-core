<?php

namespace Streams\Core\Tests\Stream\Criteria\Adapter;

use Tests\TestCase;
use Streams\Core\Entry\Entry;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Streams\Core\Support\Facades\Streams;
use Illuminate\Pagination\AbstractPaginator;

class FilebaseAdapterTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/examples.json'));
    }

    public function testCanReturnResults()
    {
        $first = Streams::entries('testing.examples')->first();
        $second = Streams::entries('testing.examples')->find('second');
        $collection = Streams::entries('testing.examples')->get();

        $this->assertEquals(2, $collection->count());
        $this->assertEquals("First Example", $first->name);
        $this->assertEquals("Second Example", $second->name);

        $this->assertInstanceOf(Entry::class, $first);
        $this->assertInstanceOf(Collection::class, $collection);
    }

    public function testCanOrderResults()
    {
        $this->assertEquals(
            "Second Example",
            Streams::entries('testing.examples')
                ->orderBy('name', 'desc')
                ->first()->name
        );
    }

    public function testCanLimitResults()
    {
        $this->assertEquals(
            "Second Example",
            Streams::entries('testing.examples')
                ->limit(1, 1)
                ->get()
                ->first()->name
        );
    }

    public function testCanConstrainResults()
    {
        $this->assertEquals(
            1,
            Streams::entries('testing.examples')
                ->where('name', 'Second Example')
                ->get()
                ->count()
        );

        $this->assertEquals(
            2,
            Streams::entries('testing.examples')
                ->where('name', 'Second Example')
                ->orWhere('name', 'First Example')
                ->get()->count()
        );

        $this->assertEquals(
            'Second Example',
            Streams::entries('testing.examples')
                ->where('name', 'Second Example')
                ->first()->name
        );

        $this->assertEquals(
            'First Example',
            Streams::entries('testing.examples')
                ->where('name', '!=', 'Second Example')
                ->first()->name
        );
    }

    public function testCanCountResults()
    {
        $this->assertEquals(2, Streams::entries('testing.examples')->count());

        $this->assertEquals(1, Streams::entries('testing.examples')->where('name', 'First Example')->count());
    }

    public function testCanPaginateResults()
    {
        $pagination = Streams::entries('testing.examples')->paginate(10);

        $this->assertInstanceOf(AbstractPaginator::class, $pagination);
        $this->assertEquals(2, $pagination->total());


        $pagination = Streams::entries('testing.examples')->paginate([
            'per_page' => 1
        ]);

        $this->assertInstanceOf(AbstractPaginator::class, $pagination);
        $this->assertEquals(2, $pagination->total());
    }

    public function testCanReturnNewInstances()
    {
        $entry = Streams::entries('testing.examples')->newInstance([
            'name' => 'Jack Smith',
        ]);

        $this->assertEquals('Jack Smith', $entry->name);
    }

    public function testCanCreateAndDelete()
    {
        $entry = Streams::entries('testing.examples')->newInstance([
            'id' => 'third',
            'name' => 'Jack Smith',
            'age' => 5,
        ]);

        Streams::repository('testing.examples')->save($entry);
        
        $this->assertEquals(3, Streams::entries('testing.examples')->count());


        Streams::repository('testing.examples')->delete($entry);

        $this->assertEquals(2, Streams::entries('testing.examples')->count());


        $entry = Streams::entries('testing.examples')->create([
            'id' => 'third',
            'name' => 'Jack Smith',
            'age' => 5,
        ]);

        $this->assertEquals('Jack Smith', $entry->name);
        $this->assertEquals(3, Streams::entries('testing.examples')->count());
    }

    // public function testCanTruncate()
    // {
    //     Streams::repository('testing.examples')->truncate();

    //     $this->assertEquals(0, Streams::entries('testing.examples')->count());

    //     $this->setUp();
    // }

    public function tearDown(): void
    {
        $this->createApplication();

        $filename = base_path('vendor/streams/core/tests/data/examples/third.json');

        if (file_exists($filename)) {
            unlink($filename);
        }
    }
}
