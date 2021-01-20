<?php

namespace Streams\Core\Tests\Stream\Criteria\Adapter;

use Tests\TestCase;
use Streams\Core\Entry\Entry;
use Illuminate\Support\Collection;
use Streams\Core\Support\Facades\Streams;
use Illuminate\Pagination\AbstractPaginator;

class FileAdapterTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/planets.json'));
    }

    // public function testCanReturnResults()
    // {
    //     $second = Streams::entries('testing.planets')->find('second');
    //     $collection = Streams::entries('testing.planets')->get();
    //     $first = Streams::entries('testing.planets')->first();
    //     $all = Streams::entries('testing.planets')->all();

    //     $this->assertEquals(2, $all->count());
    //     $this->assertEquals("First Example", $first->name);
    //     $this->assertEquals("Second Example", $second->name);

    //     $this->assertInstanceOf(Collection::class, $collection);
    //     $this->assertInstanceOf(Entry::class, $first);
    // }

    // public function testCanOrderResults()
    // {
    //     $this->assertEquals(
    //         "Second Example",
    //         Streams::entries('testing.planets')
    //             ->orderBy('name', 'desc')
    //             ->first()->name
    //     );
    // }

    // public function testCanLimitResults()
    // {
    //     $this->assertEquals(
    //         "Second Example",
    //         Streams::entries('testing.planets')
    //             ->limit(1, 1)
    //             ->get()
    //             ->first()->name
    //     );
    // }

    // public function testCanConstrainResults()
    // {
    //     $this->assertEquals(
    //         1,
    //         Streams::entries('testing.planets')
    //             ->where('name', 'Second Example')
    //             ->get()
    //             ->count()
    //     );

    //     $this->assertEquals(
    //         2,
    //         Streams::entries('testing.planets')
    //             ->where('name', 'Second Example')
    //             ->orWhere('name', 'First Example')
    //             ->get()->count()
    //     );

    //     $this->assertEquals(
    //         'Second Example',
    //         Streams::entries('testing.planets')
    //             ->where('name', 'Second Example')
    //             ->first()->name
    //     );

    //     $this->assertEquals(
    //         'First Example',
    //         Streams::entries('testing.planets')
    //             ->where('name', '!=', 'Second Example')
    //             ->first()->name
    //     );
    // }

    // public function testCanCountResults()
    // {
    //     $this->assertEquals(2, Streams::entries('testing.planets')->count());

    //     $this->assertEquals(1, Streams::entries('testing.planets')->where('name', 'First Example')->count());
    // }

    // public function testCanPaginateResults()
    // {
    //     $pagination = Streams::entries('testing.planets')->paginate(10);

    //     $this->assertInstanceOf(AbstractPaginator::class, $pagination);
    //     $this->assertEquals(2, $pagination->total());


    //     $pagination = Streams::entries('testing.planets')->paginate([
    //         'per_page' => 1
    //     ]);

    //     $this->assertInstanceOf(AbstractPaginator::class, $pagination);
    //     $this->assertEquals(2, $pagination->total());
    // }

    // public function testCanReturnNewInstances()
    // {
    //     $entry = Streams::entries('testing.planets')->newInstance([
    //         'name' => 'Jack Smith',
    //     ]);

    //     $this->assertEquals('Jack Smith', $entry->name);
    // }

    // public function testCanCreateAndDelete()
    // {
    //     $entry = Streams::entries('testing.planets')->newInstance([
    //         'id' => 'third',
    //         'name' => 'Jack Smith',
    //         'age' => 5,
    //     ]);

    //     Streams::repository('testing.planets')->save($entry);
        
    //     $this->assertEquals(3, Streams::entries('testing.planets')->count());


    //     Streams::repository('testing.planets')->delete($entry);

    //     $this->assertEquals(2, Streams::entries('testing.planets')->count());


    //     $entry = Streams::entries('testing.planets')->create([
    //         'id' => 'third',
    //         'name' => 'Jack Smith',
    //         'age' => 5,
    //     ]);

    //     $this->assertEquals('Jack Smith', $entry->name);
    //     $this->assertEquals(3, Streams::entries('testing.planets')->count());
    // }

    // public function testCanTruncate()
    // {
    //     Streams::repository('testing.planets')->truncate();

    //     $this->assertEquals(0, Streams::entries('testing.planets')->count());

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
