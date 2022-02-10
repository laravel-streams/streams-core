<?php

namespace Streams\Core\Tests\Criteria\Adapter;

use Illuminate\Support\Collection;
use Streams\Core\Tests\CoreTestCase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Streams\Core\Support\Facades\Streams;
use Illuminate\Pagination\AbstractPaginator;
use Streams\Core\Entry\Contract\EntryInterface;
use Streams\Core\Support\Traits\Streams as TraitsStreams;

class EloquentAdapterTest extends CoreTestCase
{

//     public function setUp(): void
//     {
//         $this->createApplication();

//         Streams::load(base_path('vendor/streams/core/tests/eloquent.json'));

//         $this->tearDown();

//         Schema::create('testing', function (Blueprint $table) {
//             $table->id();
//             $table->string('name');
//             $table->integer('age');
//         });

//         TestModel::create([
//             'name' => 'John Smith',
//             'age' => 30,
//         ]);

//         TestModel::create([
//             'name' => 'Jane Smith',
//             'age' => 40,
//         ]);
//     }

//     public function testCanReturnResults()
//     {
//         $first = Streams::entries('testing.eloquent')->first();
//         $second = Streams::entries('testing.eloquent')->find(2);
//         $collection = Streams::entries('testing.eloquent')->get();

//         $this->assertEquals(2, $collection->count());
//         $this->assertEquals("John Smith", $first->name);
//         $this->assertEquals("Jane Smith", $second->name);

//         $this->assertInstanceOf(TestModel::class, $first);
//         $this->assertInstanceOf(Collection::class, $collection);
//     }

//     public function testCanOrderResults()
//     {
//         $this->assertEquals(
//             "Jane Smith",
//             Streams::entries('testing.eloquent')
//                 ->orderBy('name', 'asc')
//                 ->first()->name
//         );
//     }

//     public function testCanLimitResults()
//     {
//         $this->assertEquals(
//             "Jane Smith",
//             Streams::entries('testing.eloquent')
//                 ->limit(1, 1)
//                 ->get()
//                 ->first()->name
//         );
//     }

//     public function testCanConstrainResults()
//     {
//         $this->assertEquals(
//             1,
//             Streams::entries('testing.eloquent')
//                 ->where('name', 'Jane Smith')
//                 ->get()
//                 ->count()
//         );

//         $this->assertEquals(
//             2,
//             Streams::entries('testing.eloquent')
//                 ->where('name', 'Jane Smith')
//                 ->orWhere('name', 'John Smith')
//                 ->get()->count()
//         );

//         $this->assertEquals(
//             'Jane Smith',
//             Streams::entries('testing.eloquent')
//                 ->where('name', 'Jane Smith')
//                 ->first()->name
//         );

//         $this->assertEquals(
//             'John Smith',
//             Streams::entries('testing.eloquent')
//                 ->where('name', '!=', 'Jane Smith')
//                 ->first()->name
//         );
//     }

//     public function testCanCountResults()
//     {
//         $this->assertEquals(2, Streams::entries('testing.eloquent')->count());

//         $this->assertEquals(1, Streams::entries('testing.eloquent')->where('name', 'John Smith')->count());
//     }

//     public function testCanPaginateResults()
//     {
//         $pagination = Streams::entries('testing.eloquent')->paginate(10);

//         $this->assertInstanceOf(AbstractPaginator::class, $pagination);
//         $this->assertEquals(2, $pagination->total());


//         $pagination = Streams::entries('testing.eloquent')->paginate([
//             'per_page' => 1
//         ]);

//         $this->assertInstanceOf(AbstractPaginator::class, $pagination);
//         $this->assertEquals(2, $pagination->total());
//     }

//     public function testCanReturnNewInstances()
//     {
//         $entry = Streams::entries('testing.eloquent')->newInstance([
//             'name' => 'Jack Smith',
//         ]);

//         $this->assertEquals('Jack Smith', $entry->name);
//     }

//     public function testCanCreateAndDelete()
//     {
//         $entry = Streams::entries('testing.eloquent')->newInstance([
//             'name' => 'Jack Smith',
//             'age' => 5,
//         ]);

//         Streams::repository('testing.eloquent')->save($entry);
        
//         $this->assertEquals(3, Streams::entries('testing.eloquent')->count());


//         Streams::repository('testing.eloquent')->delete($entry);

//         $this->assertEquals(2, Streams::entries('testing.eloquent')->count());


//         $entry = Streams::entries('testing.eloquent')->create([
//             'name' => 'Jack Smith',
//             'age' => 5,
//         ]);

//         $this->assertEquals('Jack Smith', $entry->name);
//         $this->assertEquals(3, Streams::entries('testing.eloquent')->count());
//     }

//     public function testCanTruncate()
//     {
//         Streams::repository('testing.eloquent')->truncate();

//         $this->assertEquals(0, Streams::entries('testing.eloquent')->count());

//         $this->setUp();
//     }

//     public function tearDown(): void
//     {
//         Schema::dropIfExists('testing');
//     }
// }

// class TestModel extends Model implements EntryInterface
// {

//     use TraitsStreams;

//     public $timestamps = false;
//     protected $table = 'testing';

//     protected $fillable = [
//         'name',
//         'age',
//     ];

//     /**
//      * Return the last modified date if possible.
//      */
//     public function lastModified()
//     {
//         return $this->once(__METHOD__, function () {

//             $datetime = $this->__updated_at;

//             if (!$datetime instanceof \Datetime) {
//                 $datetime = new \Carbon\Carbon($datetime);
//             }

//             return $datetime;
//         });
//     }
}
