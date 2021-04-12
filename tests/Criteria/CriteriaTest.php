<?php

namespace Streams\Core\Tests\Stream\Criteria;

use Tests\TestCase;
use Streams\Core\Entry\Entry;
use Illuminate\Support\Collection;
use Streams\Core\Support\Facades\Streams;
use Illuminate\Pagination\AbstractPaginator;

class CriteriaTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/examples.json'));
    }

    public function testCanReturnResults()
    {
        $second = Streams::entries('testing.examples')->find('second');
        $collection = Streams::entries('testing.examples')->get();
        $first = Streams::entries('testing.examples')->first();
        $all = Streams::entries('testing.examples')->all();

        $this->assertEquals(2, $all->count());
        $this->assertEquals("First Example", $first->name);
        $this->assertEquals("Second Example", $second->name);

        $this->assertInstanceOf(Collection::class, $collection);
        $this->assertInstanceOf(Entry::class, $first);
    }

    public function testCanCacheResults()
    {
        $entry = Streams::entries('testing.examples')->create([
            'id' => 'third',
            'name' => 'Third Example',
        ]);

        $this->assertInstanceOf(
            Entry::class,
            Streams::entries('testing.examples')
                ->cache(60)
                ->find('third')
        );

        unlink(base_path('vendor/streams/core/tests/data/examples/third.json'));

        $this->assertInstanceOf(
            Entry::class,
            Streams::entries('testing.examples')
                ->cache(60)
                ->find('third')
        );

        Streams::make('testing.examples')->flush();

        $this->assertNull(
            Streams::entries('testing.examples')
                ->find('third')
        );
    }

    public function testCanOrderResults()
    {
        $this->assertEquals(
            "Second Example",
            Streams::entries('testing.examples')
                ->orderBy('name', 'DESC')
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

    public function testParametersAccessors()
    {
        $query = Streams::entries('testing.examples')
            ->where('name', 'Second Example');

        $this->assertEquals(1, $query->get()->count());

        $query->setParameters($query->getParameters());

        $this->assertEquals(1, $query->get()->count());
    }

    public function testCanCountResults()
    {
        $this->assertEquals(2, Streams::entries('testing.examples')->cache(60)->count());
        $this->assertEquals(2, Streams::entries('testing.examples')->cache(60)->count());

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
            'name' => 'Third Example',
        ]);

        $this->assertEquals('Third Example', $entry->name);
    }

    public function testCanCreateAndDelete()
    {
        $entry = Streams::entries('testing.examples')->newInstance([
            'id' => 'third',
            'name' => 'Third Example',
        ]);

        $entry->save();

        $this->assertEquals(3, Streams::entries('testing.examples')->count());


        $entry->delete();

        $this->assertEquals(2, Streams::entries('testing.examples')->count());


        $entry = Streams::entries('testing.examples')->create([
            'id' => 'third',
            'name' => 'Third Example',
        ]);

        $this->assertEquals(3, Streams::entries('testing.examples')->count());
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
