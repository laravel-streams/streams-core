<?php

namespace Streams\Core\Tests\Criteria;

use Streams\Core\Criteria\Criteria;
use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;
use Illuminate\Pagination\AbstractPaginator;
use Streams\Core\Criteria\Adapter\FileAdapter;

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
        $count = Streams::entries('films')->cache()->count();

        $this->assertEquals(7, $entries->count());
        $this->assertEquals(7, $count);

        $file = base_path('streams/data/films.json');

        $json = json_decode(file_get_contents($file), true);

        unset($json[4]);

        file_put_contents($file, json_encode($json, JSON_PRETTY_PRINT));

        $entries = Streams::entries('films')->cache()->get();
        $count = Streams::entries('films')->cache()->count();

        $this->assertEquals(7, $entries->count());
        $this->assertEquals(7, $count);
    }

    public function test_it_caches_when_stream_cache_is_enabled()
    {
        $stream = Streams::overload('planets', [
            'config' => [
                'cache' => [
                    'enabled' => true,
                ],
            ],
        ]);

        $entries = $stream->entries()->get();
        $count = $stream->entries()->count();

        $this->assertEquals(10, $entries->count());
        $this->assertEquals(10, $count);

        $file = base_path('streams/data/planets.json');

        $json = json_decode(file_get_contents($file), true);

        unset($json[4]);

        file_put_contents($file, json_encode($json, JSON_PRETTY_PRINT));

        $entries = $stream->entries()->get();
        $count = $stream->entries()->count();

        $this->assertEquals(10, $entries->count());
        $this->assertEquals(10, $count);
    }

    public function test_it_can_flush_cache()
    {
        $entries = Streams::entries('films')->cache()->get();
        $count = Streams::entries('films')->cache()->count();

        $this->assertEquals(7, $entries->count());
        $this->assertEquals(7, $count);

        Streams::repository('films')->create($this->filmData());

        $entries = Streams::entries('films')->cache()->get();
        
        $this->assertEquals(8, $entries->count());
    }

    public function test_cache_can_be_bypassed()
    {
        $entries = Streams::entries('films')->cache()->get();

        $this->assertEquals(7, $entries->count());

        $this->removeData();

        $entries = Streams::entries('films')->fresh()->get();

        $this->assertEquals(0, $entries->count());
    }

    public function test_it_finds_by_keyname()
    {
        $entry = Streams::entries('films')->find(6);

        $this->assertEquals('Return of the Jedi', $entry->title);
    }

    public function test_it_returns_the_first_result()
    {
        $entry = Streams::entries('films')->orderBy('episode_id', 'ASC')->first();

        $this->assertEquals('The Phantom Menace', $entry->title);
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

        $this->assertEquals(
            2,
            Streams::entries('films')
                ->where('episode_id', 'IN', [1, 2])
                ->count()
        );

        $this->assertEquals(
            3,
            Streams::entries('films')
                ->where('episode_id', '<', 4)
                ->count()
        );

        $this->assertEquals(
            4,
            Streams::entries('films')
                ->where('episode_id', '<=', 4)
                ->count()
        );

        $this->assertEquals(
            3,
            Streams::entries('films')
                ->where('episode_id', '>', 4)
                ->count()
        );

        $this->assertEquals(
            4,
            Streams::entries('films')
                ->where('episode_id', '>=', 4)
                ->count()
        );
    }

    public function test_it_gets_and_sets_query_parameters()
    {
        $query = Streams::entries('films')->where('title', 'A New Hope');

        $parameters = $query->getParameters();

        $this->assertEquals(1, $query->get()->count());

        $query->setParameters($parameters);

        $this->assertEquals(1, $query->get()->count());
    }

    public function test_it_paginates_results()
    {
        $pagination = Streams::entries('films')->paginate();

        $this->assertInstanceOf(AbstractPaginator::class, $pagination);
        $this->assertEquals(7, $pagination->total());

        $pagination = Streams::entries('films')->paginate(2);

        $this->assertInstanceOf(AbstractPaginator::class, $pagination);
        $this->assertEquals(7, $pagination->total());
    }

    public function test_it_returns_new_instances()
    {
        $entry = Streams::entries('films')->newInstance($this->filmData());

        $this->assertEquals(8, $entry->episode_id);
        $this->assertEquals('Star Wars: The Last Jedi', $entry->title);
    }

    public function test_it_creates_entries()
    {
        Streams::entries('films')->create($this->filmData());

        $this->assertEquals(8, Streams::entries('films')->count());
    }

    public function test_it_saves_entries()
    {
        $entry = Streams::entries('films')->first();

        $entry->title = 'Test Title';

        Streams::entries('films')->save($entry);

        $entry = Streams::entries('films')->first();

        $this->assertEquals('Test Title', $entry->title);
    }

    public function test_it_deletes_entries()
    {
        Streams::entries('films')
            ->where('episode_id', 4)
            ->delete();

        $this->assertEquals(6, Streams::entries('films')->count());
    }

    public function test_it_truncates_entries()
    {
        Streams::entries('films')->truncate();

        $this->assertEquals(0, Streams::entries('films')->count());
    }

    public function test_it_can_chunk_results()
    {
        Streams::entries('films')
            ->orderBy('episode_id', 'ASC')
            ->chunk(1, function ($entries) {
                $entries->each(function ($entry) {
                    echo $entry->title;
                });
            });

        $expected = '';

        Streams::entries('films')
            ->orderBy('episode_id', 'ASC')
            ->get()
            ->each(function ($film) use (&$expected) {
                $expected .= $film->title;
            });

        $this->expectOutputString($expected);
    }

    public function test_it_can_stop_chunking_results()
    {
        Streams::entries('films')->orderBy('episode_id', 'ASC')->chunk(1, function ($entries) {
            $entries->each(function ($entry) {
                echo $entry->title;
            });
            return false;
        });

        $this->expectOutputString('The Phantom Menace');
    }

    public function test_it_uses_stream_defined_criteria()
    {
        $stream = Streams::overload('films', [
            'config' => [
                'criteria' => CustomExamplesCriteria::class,
            ],
        ]);

        $this->assertInstanceOf(CustomExamplesCriteria::class, $stream->entries());

        $entry = $stream->entries()->test();

        $this->assertEquals('The Phantom Menace', $entry->title);
    }

    public function test_it_uses_stream_defined_adapter()
    {
        $stream = Streams::overload('films', [
            'config' => [
                'source' => [
                    'adapter' => CustomExamplesAdapter::class,
                ],
            ],
        ]);

        $entry = $stream->entries()->testMethod()->first();

        $this->assertEquals('The Phantom Menace', $entry->title);
    }

    public function test_it_supports_eager_loading()
    {
        $entries = Streams::people()->with(['homeworld'])->get();

        $this->assertEquals('Tatooine', $entries->first()->homeworld->name);
    }

    public function test_it_supports_macros()
    {
        Streams::entries('films')->macro('testMacro', function () {
            return $this->orderBy('title', 'DESC')->first();
        });

        $entry = Streams::entries('films')->testMacro();

        $this->assertEquals('The Phantom Menace', $entry->title);
    }

    public function test_it_throws_exception_for_bad_methods()
    {
        $this->expectException(\Exception::class);

        Streams::entries('films')->doesntExist();
    }

    protected function filmData()
    {
        $datetime = now();

        return [
            'title' => 'Star Wars: The Last Jedi',
            'created' => $datetime,
            'edited' => $datetime,
            'director' => 'Rian Johnson',
            'producer' => 'Kathleen Kennedy, Ram Bergman, J. J. Abrams',
            'release_date' => '2017-12-15',
            'opening_crawl' => 'The FIRST ORDER reigns. Having decimated the peaceful Republic, Supreme Leader Snoke now deploys his merciless legions to seize military control of the galaxy.

Only General Leia Organa\'s band of RESISTANCE fighters stand against the rising tyranny, certain that Jedi Master Luke Skywalker will return and restore a spark of hope to the fight.

But the Resistance has been exposed. As the First Order speeds toward the rebel base, the brave heroes mount a desperate escape....',
            'characters' => [1, 5],
            'starships' => [9],
            'vehicles' => [],
            'planets' => [],
            'species' => [1],
        ];
    }

    protected function removeData()
    {
        unlink(base_path('streams/data/films.' . Streams::make('films')->config('source.format', 'json')));
    }
}


class CustomExamplesCriteria extends Criteria
{
    public function test()
    {
        return $this->orderBy('title', 'DESC')->first();
    }
}

class CustomExamplesAdapter extends FileAdapter
{
    public function testMethod()
    {
        return $this->orderBy('title', 'DESC');
    }
}
