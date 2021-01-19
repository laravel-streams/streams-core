<?php

namespace Streams\Core\Tests\Stream\Criteria\Format;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Streams\Core\Support\Facades\Streams;

class DatabaseAdapterTest extends TestCase
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
            'name' => 'John Smith',
            'age' => 30,
        ]);

        DB::table('testing')->insert([
            'name' => 'Jane Smith',
            'age' => 40,
        ]);
    }

    public function testCanReturnResults()
    {
        $second = Streams::entries('testing.database')->find(2);
        //$collection = Streams::entries('testing.database')->get();
        // $first = Streams::entries('testing.database')->first();
        // $all = Streams::entries('testing.database')->all();

        // $this->assertEquals(2, $all->count());
        // $this->assertEquals("John Smith", $first->name);
        $this->assertEquals("Jane Smith", $second->name);

        //$this->assertInstanceOf(Collection::class, $collection);
        //$this->assertInstanceOf(Entry::class, $first);
    }

    // public function testCanOrderResults()
    // {
    //     $this->assertEquals(
    //         "Second Example",
    //         Streams::entries('testing.database')
    //             ->orderBy('name', 'DESC')
    //             ->first()->name
    //     );
    // }

    // public function testCanLimitResults()
    // {
    //     $this->assertEquals(
    //         "Second Example",
    //         Streams::entries('testing.database')
    //             ->limit(1, 1)
    //             ->get()
    //             ->first()->name
    //     );
    // }

    // public function testCanConstrainResults()
    // {
    //     $this->assertEquals(
    //         1,
    //         Streams::entries('testing.database')
    //             ->where('name', 'Second Example')
    //             ->get()
    //             ->count()
    //     );

    //     $this->assertEquals(
    //         2,
    //         Streams::entries('testing.database')
    //             ->where('name', 'Second Example')
    //             ->orWhere('name', 'First Example')
    //             ->get()->count()
    //     );

    //     $this->assertEquals(
    //         'Second Example',
    //         Streams::entries('testing.database')
    //             ->where('name', 'Second Example')
    //             ->first()->name
    //     );

    //     $this->assertEquals(
    //         'First Example',
    //         Streams::entries('testing.database')
    //             ->where('name', '!=', 'Second Example')
    //             ->first()->name
    //     );
    // }

    // public function testCanCountResults()
    // {
    //     $this->assertEquals(2, Streams::entries('testing.database')->count());

    //     $this->assertEquals(1, Streams::entries('testing.database')->where('name', 'First Example')->count());
    // }

    // public function testCanPaginateResults()
    // {
    //     $pagination = Streams::entries('testing.database')->paginate(10);

    //     $this->assertInstanceOf(AbstractPaginator::class, $pagination);
    //     $this->assertEquals(2, $pagination->total());

        
    //     $pagination = Streams::entries('testing.database')->paginate([
    //         'per_page' => 1
    //     ]);

    //     $this->assertInstanceOf(AbstractPaginator::class, $pagination);
    //     $this->assertEquals(2, $pagination->total());
    // }

    // public function testCanReturnNewInstances()
    // {
    //     $entry = Streams::entries('testing.database')->newInstance([
    //         'name' => 'Third Example',
    //     ]);

    //     $this->assertEquals('Third Example', $entry->name);
    // }

    // public function testCanCreateAndDelete()
    // {
    //     $entry = Streams::entries('testing.database')->newInstance([
    //         'id' => 'third',
    //         'name' => 'Third Example',
    //     ]);

    //     $entry->save();

    //     $this->assertEquals(3, Streams::entries('testing.database')->count());


    //     $entry->delete();

    //     $this->assertEquals(2, Streams::entries('testing.database')->count());


    //     $entry = Streams::entries('testing.database')->create([
    //         'id' => 'third',
    //         'name' => 'Third Example',
    //     ]);

    //     $this->assertEquals(3, Streams::entries('testing.database')->count());
    // }

    public function tearDown(): void
    {
        Schema::dropIfExists('testing');
    }
}
