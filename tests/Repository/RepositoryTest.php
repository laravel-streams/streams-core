<?php

namespace Streams\Core\Tests\Stream\Repository;

use Illuminate\Support\Collection;
use Streams\Core\Criteria\Adapter\FileAdapter;
use Streams\Core\Criteria\Criteria;
use Streams\Core\Entry\Entry;
use Streams\Core\Stream\Stream;
use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;

class RepositoryTest extends CoreTestCase
{
    public function test_it_returns_all_results()
    {
        $entries = Streams::repository('films')->all();

        $this->assertEquals(7, $entries->count());
    }

    public function test_it_finds_results_by_id()
    {
        $entry = Streams::repository('films')->find(4);

        $this->assertEquals('A New Hope', $entry->title);
    }

    public function test_it_finds_all_results_matching_ids()
    {
        $entries = Streams::repository('films')->findAll([3, 4]);

        $this->assertEquals(2, $entries->count());
    }

    public function test_it_finds_results_by_specified_value()
    {
        $second = Streams::repository('films')->findBy('title', 'A New Hope');

        $this->assertEquals('A New Hope', $second->title);
    }

    public function test_it_finds_all_by_specified_value()
    {
        $entries = Streams::repository('films')
            ->findAllWhere('opening_crawl', 'LIKE', '%Jedi%');

        $this->assertEquals(4, $entries->count());
    }

    public function test_it_creates_entries()
    {
        Streams::repository('films')->create($this->filmData());

        $this->assertEquals(8, Streams::repository('films')->count());
    }

    public function test_is_saves_entries()
    {
        $entry = Streams::repository('films')->find(4);

        $entry->title = 'Test Title';

        Streams::repository('films')->save($entry);

        $entry = Streams::repository('films')->find(4);

        $this->assertEquals('Test Title', $entry->title);
    }

    public function test_it_deletes_entries()
    {
        $entry = Streams::repository('films')->find(4);

        Streams::repository('films')->delete($entry);

        $this->assertEquals(6, Streams::repository('films')->count());
    }

    public function test_it_returns_new_instances()
    {
        $entry = Streams::repository('films')->newInstance($this->filmData());

        $this->assertEquals(8, $entry->episode_id);
        $this->assertEquals('Star Wars: The Last Jedi', $entry->title);
    }

    public function test_it_truncates_entries()
    {
        Streams::repository('films')->truncate();

        $this->assertEquals(0, Streams::repository('films')->count());
    }

    public function test_it_returns_new_criteria()
    {
        $this->assertInstanceOf(
            Criteria::class,
            Streams::repository('films')->newCriteria()
        );
    }

    public function test_it_returns_stream_defined_criteria()
    {
        $stream = Streams::overload('films', [
            'config' => [
                'criteria' => CustomCriteria::class,
            ],
        ]);

        $this->assertInstanceOf(
            CustomCriteria::class,
            $stream->repository('films')->newCriteria()
        );
    }

    public function test_it_uses_stream_defined_adapter()
    {
        $stream = Streams::overload('films', [
            'config' => [
                'source' => [
                    'adapter' => CustomAdapter::class,
                ],
            ],
        ]);

        $entry = $stream->repository()
            ->newCriteria()
            ->testMethod()
            ->first();

        $this->assertEquals('The Phantom Menace', $entry->title);
    }

    public function test_it_returns_stream_defined_collections()
    {
        $stream = Streams::overload('films', [
            'config' => [
                'collection' => CustomCollection::class,
            ],
        ]);

        $this->assertInstanceOf(
            CustomCollection::class,
            $stream->repository('films')->all()
        );
    }

    protected function filmData()
    {
        return [
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

class CustomCriteria extends Criteria
{
}

class CustomCollection extends Collection
{
}

class CustomAdapter extends FileAdapter
{
    public function testMethod()
    {
        return $this->orderBy('title', 'DESC');
    }
}
