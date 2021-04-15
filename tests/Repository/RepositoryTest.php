<?php

namespace Streams\Core\Tests\Stream\Repository;

use Tests\TestCase;
use Streams\Core\Entry\Entry;
use Illuminate\Support\Collection;
use Streams\Core\Support\Facades\Streams;
use Illuminate\Pagination\AbstractPaginator;

class RepositoryTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/examples.json'));
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

    // public function testCanCacheResults()
    // {
    //     $entry = Streams::repository('testing.examples')->create([
    //         'id' => 'third',
    //         'name' => 'Third Example',
    //     ]);

    //     $this->assertInstanceOf(
    //         Entry::class,
    //         Streams::repository('testing.examples')
    //             ->cache(60)
    //             ->find('third')
    //     );

    //     unlink(base_path('vendor/streams/core/tests/data/examples/third.json'));

    //     $this->assertInstanceOf(
    //         Entry::class,
    //         Streams::repository('testing.examples')
    //             ->cache(60)
    //             ->find('third')
    //     );

    //     Streams::make('testing.examples')->flush();

    //     $this->assertNull(
    //         Streams::repository('testing.examples')
    //             ->find('third')
    //     );
    // }

    // public function testCanOrderResults()
    // {
    //     $this->assertEquals(
    //         "Second Example",
    //         Streams::repository('testing.examples')
    //             ->orderBy('name', 'DESC')
    //             ->first()->name
    //     );
    // }

    // public function testCanLimitResults()
    // {
    //     $this->assertEquals(
    //         "Second Example",
    //         Streams::repository('testing.examples')
    //             ->limit(1, 1)
    //             ->get()
    //             ->first()->name
    //     );
    // }

    // public function testCanConstrainResults()
    // {
    //     $this->assertEquals(
    //         1,
    //         Streams::repository('testing.examples')
    //             ->where('name', 'Second Example')
    //             ->get()
    //             ->count()
    //     );

    //     $this->assertEquals(
    //         2,
    //         Streams::repository('testing.examples')
    //             ->where('name', 'Second Example')
    //             ->orWhere('name', 'First Example')
    //             ->get()->count()
    //     );

    //     $this->assertEquals(
    //         'Second Example',
    //         Streams::repository('testing.examples')
    //             ->where('name', 'Second Example')
    //             ->first()->name
    //     );

    //     $this->assertEquals(
    //         'First Example',
    //         Streams::repository('testing.examples')
    //             ->where('name', '!=', 'Second Example')
    //             ->first()->name
    //     );
    // }

    // public function testParametersAccessors()
    // {
    //     $query = Streams::repository('testing.examples')
    //         ->where('name', 'Second Example');

    //     $this->assertEquals(1, $query->get()->count());

    //     $query->setParameters($query->getParameters());

    //     $this->assertEquals(1, $query->get()->count());
    // }

    // public function testCanPaginateResults()
    // {
    //     $pagination = Streams::repository('testing.examples')->paginate(10);

    //     $this->assertInstanceOf(AbstractPaginator::class, $pagination);
    //     $this->assertEquals(2, $pagination->total());


    //     $pagination = Streams::repository('testing.examples')->paginate([
    //         'per_page' => 1
    //     ]);

    //     $this->assertInstanceOf(AbstractPaginator::class, $pagination);
    //     $this->assertEquals(2, $pagination->total());
    // }

    // public function testCanReturnNewInstances()
    // {
    //     $entry = Streams::repository('testing.examples')->newInstance([
    //         'name' => 'Third Example',
    //     ]);

    //     $this->assertEquals('Third Example', $entry->name);
    // }

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
        $this->createApplication();

        $filename = base_path('vendor/streams/core/tests/data/examples/third.json');

        if (file_exists($filename)) {
            unlink($filename);
        }
    }
}
