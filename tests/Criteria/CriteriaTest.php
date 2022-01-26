<?php

namespace Streams\Core\Tests\Stream\Criteria;

use Tests\TestCase;
use Streams\Core\Entry\Entry;
use Streams\Core\Criteria\Criteria;
use Illuminate\Support\Facades\Crypt;
use Streams\Core\Support\Facades\Streams;
use Illuminate\Pagination\AbstractPaginator;
use Streams\Core\Criteria\Adapter\FilebaseAdapter;

class CriteriaTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/examples.json'));
    }

    public function tearDown(): void
    {
        $this->createApplication();

        $filename = base_path('vendor/streams/core/tests/data/examples/third.json');

        if (file_exists($filename)) {
            unlink($filename);
        }
    }

    public function test_can_get_entries()
    {
        $entries = Streams::entries('testing.examples')->get();

        $this->assertEquals(2, $entries->count());
    }

    public function test_can_return_the_first_result()
    {
        $entry = Streams::entries('testing.examples')->first();

        $this->assertEquals('First Example', $entry->name);
    }

    public function test_can_find_an_entry_by_id()
    {
        $entry = Streams::entries('testing.examples')->find('second');

        $this->assertEquals('Second Example', $entry->name);
    }

    public function test_can_order_results()
    {
        $entry = Streams::entries('testing.examples')->orderBy('name', 'DESC')->first();

        $this->assertEquals('Second Example', $entry->name);
    }

    public function test_can_limit_results()
    {
        $entries = Streams::entries('testing.examples')->limit(1)->get();

        $this->assertEquals(1, $entries->count());
    }

    public function test_can_count_results()
    {
        $this->assertEquals(2, Streams::entries('testing.examples')->count());
    }

    public function test_can_constrain_results()
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
            2,
            Streams::entries('testing.examples')
                ->where('name', 'LIKE', '% Example')
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

    public function test_can_get_and_set_query_parameters()
    {
        $query = Streams::entries('testing.examples')->where('name', 'Second Example');

        $this->assertEquals(1, $query->get()->count());

        $query->setParameters($query->getParameters());

        $this->assertEquals(1, $query->get()->count());
    }

    public function test_can_load_array_of_parameters()
    {
        $query = Streams::entries('testing.examples');

        $query->loadParameters([
            ['where' => ['name', 'First Example']]
        ]);

        $this->assertEquals(1, $query->get()->count());
    }

    public function test_can_paginate_results()
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

    public function test_can_return_new_instances()
    {
        $entry = Streams::entries('testing.examples')->newInstance([
            'name' => 'Third Example',
        ]);

        $this->assertEquals('Third Example', $entry->name);
    }

    public function test_new_instances_modify_attributes()
    {
        $entry = Streams::entries('testing.examples')->newInstance([
            'name' => 'Modified Example',
            'password' => 'password_test',
        ]);

        $this->assertNotEquals('password_test', $entry->password);
    }

    public function test_results_do_not_modify_attributes()
    {
        $entry = Streams::entries('testing.examples')->first('first');

        $this->assertEquals('password', Crypt::decrypt($entry->password));
    }

    public function test_can_create_and_delete_entries()
    {
        $entry = Streams::entries('testing.examples')->create([
            'id' => 'third',
            'name' => 'Third Example',
        ]);

        $this->assertEquals(3, Streams::entries('testing.examples')->count());

        Streams::entries('testing.examples')->delete($entry);

        $this->assertEquals(2, Streams::entries('testing.examples')->count());
    }

    public function test_can_cache_results()
    {
        Streams::entries('testing.examples')->create([
            'id' => 'third',
            'name' => 'Third Example',
        ]);

        $count = Streams::entries('testing.examples')->cache()->count();
        $entry = Streams::entries('testing.examples')->cache(60)->find('third');

        $this->assertEquals(3, $count);
        $this->assertInstanceOf(Entry::class, $entry);

        // Circumvent cache.
        unlink(base_path('vendor/streams/core/tests/data/examples/third.json'));

        $count = Streams::entries('testing.examples')->cache()->count();
        $entry = Streams::entries('testing.examples')->cache(60)->find('third');

        $this->assertEquals(3, $count);
        $this->assertInstanceOf(Entry::class, $entry);
    }

    public function test_can_flush_cache()
    {
        Streams::entries('testing.examples')->create([
            'id' => 'third',
            'name' => 'Third Example',
        ]);

        Streams::entries('testing.examples')->cache(60)->find('third');

        // Circumvent cache.
        unlink(base_path('vendor/streams/core/tests/data/examples/third.json'));

        Streams::make('testing.examples')->cache()->flush();

        $entry = Streams::entries('testing.examples')->cache(60)->find('third');

        $this->assertNull($entry);
    }

    public function test_can_bypass_cache()
    {
        Streams::entries('testing.examples')->create([
            'id' => 'third',
            'name' => 'Third Example',
        ]);

        Streams::entries('testing.examples')->cache(60)->find('third');

        // Circumvent cache.
        unlink(base_path('vendor/streams/core/tests/data/examples/third.json'));

        $entry = Streams::entries('testing.examples')->fresh()->find('third');

        $this->assertNull($entry);
    }

    public function test_can_chunk_results()
    {
        Streams::entries('testing.examples')->chunk(1, function ($entries) {
            $entries->each(function ($entry) {
                echo $entry->name;
            });
        });

        $this->expectOutputString('First ExampleSecond Example');
    }

    public function test_can_stop_chunking_results()
    {
        Streams::entries('testing.examples')->chunk(1, function ($entries) {
            $entries->each(function ($entry) {
                echo $entry->name;
            });
            return false;
        });

        $this->expectOutputString('First Example');
    }

    public function test_streams_can_define_custom_criteria()
    {
        $stream = Streams::build([
            'id' => 'testing.custom_criteria',
            'config' => [
                'source' => [
                    'path' => 'vendor/streams/core/tests/data/examples',
                    'format' => 'json'
                ],
                'criteria' => CustomExamplesCriteria::class,
            ]
        ]);

        $this->assertInstanceOf(CustomExamplesCriteria::class, $stream->entries());

        $entry = $stream->entries()->test();

        $this->assertEquals('Second Example', $entry->name);
    }

    public function test_streams_can_define_custom_adapter()
    {
        $stream = Streams::build([
            'id' => 'testing.custom_adapter',
            'config' => [
                'source' => [
                    'adapter' => CustomExamplesAdapter::class,
                    'path' => 'vendor/streams/core/tests/data/examples',
                    'format' => 'json'
                ],
            ]
        ]);

        $entry = $stream->entries()->testMethod()->first();

        $this->assertEquals('Second Example', $entry->name);
    }

    public function test_criteria_are_macroable()
    {
        Streams::entries('testing.examples')->macro('testMacro', function() {
            return $this->orderBy('name', 'DESC')->first();
        });

        $entry = Streams::entries('testing.examples')->testMacro();
        
        $this->assertEquals('Second Example', $entry->name);
    }

    public function test_it_throws_exception_for_bad_methods()
    {
        $this->expectException(\Exception::class);

        Streams::entries('testing.examples')->doesntExist();
    }
}


class CustomExamplesCriteria extends Criteria
{
    public function test()
    {
        return $this->orderBy('name', 'DESC')->first();
    }
}

class CustomExamplesAdapter extends FilebaseAdapter
{
    public function testMethod()
    {
        return $this->orderBy('name', 'DESC');
    }
}
