<?php

namespace Streams\Core\Tests\Stream\Criteria;

use Streams\Core\Criteria\Criteria;
use Streams\Core\Tests\CoreTestCase;
use Illuminate\Support\Facades\Crypt;
use Streams\Core\Support\Facades\Streams;
use Illuminate\Pagination\AbstractPaginator;
use Streams\Core\Criteria\Adapter\FilebaseAdapter;

class CriteriaTest extends CoreTestCase
{

    public function test_it_returns_entries()
    {
        $entries = Streams::entries('films')->get();

        $this->assertEquals(7, $entries->count());
    }

    public function test_it_caches_results()
    {
        $entries = Streams::entries('films')->cache()->get();

        $this->assertEquals(7, $entries->count());

        $file = base_path('streams/data/films.json');

        $json = json_decode(file_get_contents($file), true);

        unset($json[4]);

        file_put_contents($file, json_encode($json, JSON_PRETTY_PRINT));

        $entries = Streams::entries('films')->cache()->get();

        $this->assertEquals(7, $entries->count());
    }

    public function test_it_caches_when_stream_cache_enabled()
    {
        $stream = Streams::overload('planets', [
            'config' => [
                'cache' => [
                    'enabled' => true,
                ],
            ],
        ]);

        $entries = $stream->entries()->get();

        $this->assertEquals(10, $entries->count());

        $file = base_path('streams/data/planets.json');

        $json = json_decode(file_get_contents($file), true);

        unset($json[4]);

        file_put_contents($file, json_encode($json, JSON_PRETTY_PRINT));

        $entries = $stream->entries()->get();

        $this->assertEquals(10, $entries->count());
    }

    public function test_can_flush_cache()
    {
        $this->test_it_caches_results();

        Streams::repository('films')->create($this->filmData());

        $entries = Streams::entries('films')->cache()->get();

        $this->assertEquals(7, $entries->count());
    }

    public function test_cache_can_be_bypassed()
    {
        $entries = Streams::entries('films')->cache()->get();

        $this->assertEquals(7, $entries->count());

        $file = base_path('streams/data/films.json');

        $json = json_decode(file_get_contents($file), true);

        unset($json[4]);

        file_put_contents($file, json_encode($json, JSON_PRETTY_PRINT));

        $entries = Streams::entries('films')->fresh()->get();

        $this->assertEquals(6, $entries->count());
    }

    public function test_it_returns_the_first_result()
    {
        $entry = Streams::entries('films')->first();

        $this->assertEquals('A New Hope', $entry->title);
    }

    public function test_it_orders_results()
    {
        $entry = Streams::entries('films')->orderBy('title', 'DESC')->first();

        $this->assertEquals('The Phantom Menace', $entry->title);
    }

    public function test_it_limits_results()
    {
        $entries = Streams::entries('films')->limit(2)->get();

        $this->assertEquals(2, $entries->count());
    }

    public function test_it_counts_results()
    {
        $this->assertEquals(7, Streams::entries('films')->count());
    }

    public function test_it_filters_results()
    {
        $this->assertEquals(
            3,
            Streams::entries('films')
                ->where('opening_crawl', 'LIKE', '%Skywalker%')
                ->count()
        );
    }

    public function test_can_get_and_set_query_parameters()
    {
        $query = Streams::entries('films')->where('name', 'Second Example');

        $this->assertEquals(1, $query->get()->count());

        $query->setParameters($query->getParameters());

        $this->assertEquals(1, $query->get()->count());
    }

    public function test_can_load_array_of_parameters()
    {
        $query = Streams::entries('films');

        $query->loadParameters([
            ['where' => ['name', 'First Example']]
        ]);

        $this->assertEquals(1, $query->get()->count());
    }

    public function test_can_paginate_results()
    {
        $pagination = Streams::entries('films')->paginate(10);

        $this->assertInstanceOf(AbstractPaginator::class, $pagination);
        $this->assertEquals(2, $pagination->total());


        $pagination = Streams::entries('films')->paginate([
            'per_page' => 1
        ]);

        $this->assertInstanceOf(AbstractPaginator::class, $pagination);
        $this->assertEquals(2, $pagination->total());
    }

    public function test_can_return_new_instances()
    {
        $entry = Streams::entries('films')->newInstance([
            'name' => 'Third Example',
        ]);

        $this->assertEquals('Third Example', $entry->name);
    }

    public function test_new_instances_modify_attributes()
    {
        $entry = Streams::entries('films')->newInstance([
            'name' => 'Modified Example',
            'password' => 'password_test',
        ]);

        $this->assertNotEquals('password_test', $entry->password);
    }

    public function test_results_do_not_modify_attributes()
    {
        $entry = Streams::entries('films')->first('first');

        $this->assertEquals('password', Crypt::decrypt($entry->password));
    }

    public function test_can_create_and_delete_entries()
    {
        $entry = Streams::entries('films')->create([
            'id' => 'third',
            'name' => 'Third Example',
        ]);

        $this->assertEquals(3, Streams::entries('films')->count());

        Streams::entries('films')
            ->where('id', $entry->id)
            ->delete();

        $this->assertEquals(2, Streams::entries('films')->count());
    }

    public function test_can_chunk_results()
    {
        Streams::entries('films')->chunk(1, function ($entries) {
            $entries->each(function ($entry) {
                echo $entry->name;
            });
        });

        $this->expectOutputString('First ExampleSecond Example');
    }

    public function test_can_stop_chunking_results()
    {
        Streams::entries('films')->chunk(1, function ($entries) {
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
        Streams::entries('films')->macro('testMacro', function() {
            return $this->orderBy('name', 'DESC')->first();
        });

        $entry = Streams::entries('films')->testMacro();
        
        $this->assertEquals('Second Example', $entry->name);
    }

    public function test_it_throws_exception_for_bad_methods()
    {
        $this->expectException(\Exception::class);

        Streams::entries('films')->doesntExist();
    }

    protected function filmData()
    {
        return [
            'episode_id' => 8,
            'title' => 'Star Wars: The Last Jedi',
            'director' => 'Rian Johnson',
            'producer' => 'Kathleen Kennedy, Ram Bergman, J. J. Abrams',
            'release_date' => '2017-12-15',
            'opening_crawl' => 'The FIRST ORDER reigns. Having decimated the peaceful Republic, Supreme Leader Snoke now deploys his merciless legions to seize military control of the galaxy.

Only General Leia Organa\'s band of RESISTANCE fighters stand against the rising tyranny, certain that Jedi Master Luke Skywalker will return and restore a spark of hope to the fight.

"But the Resistance has been exposed. As the First Order speeds toward the rebel base, the brave heroes mount a desperate escape....',
            'characters' => [1, 5],
            'planets' => [],
            'starships' => [9],
            'species' => [1],
        ];
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
