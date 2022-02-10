<?php

namespace Streams\Core\Tests\Criteria\Adapter;

use Streams\Core\Entry\Entry;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Streams\Core\Tests\CoreTestCase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Streams\Core\Support\Facades\Streams;
use Illuminate\Pagination\AbstractPaginator;

class DatabaseAdapterTest extends CoreTestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/database.json'));

        $this->tearDown();

        Schema::create('testing', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('age');
        });

        DB::table('testing')->insert([
            'id' => 1,
            'name' => 'John Smith',
            'age' => 30,
        ]);

        DB::table('testing')->insert([
            'id' => 2,
            'name' => 'Jane Smith',
            'age' => 40,
        ]);
    }

    public function testCanReturnResults()
    {
        $first = Streams::entries('testing.database')->first();
        $second = Streams::entries('testing.database')->find(2);
        $collection = Streams::entries('testing.database')->get();

        $this->assertEquals(2, $collection->count());
        $this->assertEquals("John Smith", $first->name);
        $this->assertEquals("Jane Smith", $second->name);

        $this->assertInstanceOf(Entry::class, $first);
        $this->assertInstanceOf(Collection::class, $collection);
    }

    public function testCanOrderResults()
    {
        $this->assertEquals(
            "Jane Smith",
            Streams::entries('testing.database')
                ->orderBy('name', 'asc')
                ->first()->name
        );
    }

    public function testCanLimitResults()
    {
        $this->assertEquals(
            "Jane Smith",
            Streams::entries('testing.database')
                ->limit(1, 1)
                ->get()
                ->first()->name
        );
    }

    public function testCanConstrainResults()
    {
        $this->assertEquals(
            1,
            Streams::entries('testing.database')
                ->where('name', 'Jane Smith')
                ->get()
                ->count()
        );

        $this->assertEquals(
            2,
            Streams::entries('testing.database')
                ->where('name', 'Jane Smith')
                ->orWhere('name', 'John Smith')
                ->get()->count()
        );

        $this->assertEquals(
            'Jane Smith',
            Streams::entries('testing.database')
                ->where('name', 'Jane Smith')
                ->first()->name
        );

        $this->assertEquals(
            'John Smith',
            Streams::entries('testing.database')
                ->where('name', '!=', 'Jane Smith')
                ->first()->name
        );
    }

    public function testCanCountResults()
    {
        $this->assertEquals(2, Streams::entries('testing.database')->count());

        $this->assertEquals(1, Streams::entries('testing.database')->where('name', 'John Smith')->count());
    }

    public function testCanPaginateResults()
    {
        $pagination = Streams::entries('testing.database')->paginate(10);

        $this->assertInstanceOf(AbstractPaginator::class, $pagination);
        $this->assertEquals(2, $pagination->total());


        $pagination = Streams::entries('testing.database')->paginate([
            'per_page' => 1
        ]);

        $this->assertInstanceOf(AbstractPaginator::class, $pagination);
        $this->assertEquals(2, $pagination->total());
    }

    public function testCanReturnNewInstances()
    {
        $entry = Streams::entries('testing.database')->newInstance([
            'name' => 'Jack Smith',
        ]);

        $this->assertEquals('Jack Smith', $entry->name);
    }

    public function testCanCreateAndDeleteEntries()
    {
        $entry = Streams::entries('testing.database')->newInstance([
            'name' => 'Jack Smith',
            'age' => 5,
        ]);

        $entry->save();

        $this->assertEquals(3, Streams::entries('testing.database')->count());

        $entry->delete();

        $this->assertEquals(2, Streams::entries('testing.database')->count());
    }

    public function testCanUpdateEntries()
    {
        $entry = Streams::entries('testing.database')
            ->where('name', 'Jane Smith')
            ->first();

        $entry->age = 10;

        $entry->save();

        $entry = Streams::entries('testing.database')
            ->where('name', 'Jane Smith')
            ->first();

        $this->assertEquals(10, $entry->age);
    }

    public function testCanTruncate()
    {
        Streams::repository('testing.database')->truncate();

        $this->assertEquals(0, Streams::entries('testing.database')->count());

        $this->setUp();
    }

    public function tearDown(): void
    {
        Schema::dropIfExists('testing');
    }
}
