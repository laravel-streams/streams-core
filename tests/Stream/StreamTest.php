<?php

namespace Streams\Core\Tests\Stream;

use Streams\Core\Criteria\Criteria;
use Streams\Core\Stream\StreamCache;
use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Stream\StreamSchema;
use Streams\Core\Repository\Repository;
use Streams\Core\Support\Facades\Streams;
use Illuminate\Contracts\Validation\Validator;
use Streams\Core\Entry\Contract\EntryInterface;

class StreamTest extends CoreTestCase
{
    public function test_it_creates_entries_through_the_configured_repository()
    {
        $stream = Streams::overload('films', [
            'config' => ['repository' => FilmCreationRepository::class],
        ]);

        $film = $stream->create(['episode_id' => 8, 'title' => 'Custom Film']);

        $this->assertInstanceOf(FilmCreationRepository::class, $stream->repository());
        $this->assertSame($stream, $film->stream());
        $this->assertSame('Repository: Custom Film', $film->title);
        $this->assertSame('Repository: Custom Film', $stream->repository()->find(8)->title);
        $this->assertSame(8, $stream->repository()->count());
    }

    public function test_it_creates_and_persists_film_entries_using_custom_test_helper()
    {
        $film = $this->createFilm(['title' => 'My Film', 'episode_id' => 8]);

        $this->assertInstanceOf(EntryInterface::class, $film);
        $this->assertSame(Streams::make('films'), $film->stream());
        $this->assertSame('My Film', $film->title);
        $this->assertSame('Test Director', $film->director);
        $this->assertSame(now()->format('Y-m-d'), $film->release_date->format('Y-m-d'));
        $this->assertSame(8, Streams::repository('films')->count());
        $this->assertSame('My Film', Streams::repository('films')->find(8)->title);
    }

    protected function createFilm(array $attributes = []): object
    {
        return Streams::make('films')->create(array_merge([
            'title' => 'Test Film',
            'director' => 'Test Director',
            'release_date' => now()->format('Y-m-d'),
        ], $attributes));
    }

    public function test_it_is_arrayable()
    {
        $this->assertIsArray(Streams::make('films')->toArray());
    }

    public function test_it_is_jsonable()
    {
        $this->assertJson(Streams::make('films')->toJson());
        $this->assertJson((string) Streams::make('films'));
    }

    public function test_it_returns_entry_criteria()
    {
        $this->assertInstanceOf(Criteria::class, Streams::entries('films'));
    }

    public function test_it_returns_entry_repository()
    {
        $this->assertInstanceOf(Repository::class, Streams::repository('films'));
    }

    public function test_it_returns_validator()
    {
        $this->assertInstanceOf(Validator::class, Streams::make('films')->validator([]));
    }

    public function test_it_returns_schema()
    {
        $this->assertInstanceOf(StreamSchema::class, Streams::make('films')->schema());
    }

    public function test_it_returns_cache()
    {
        $this->assertInstanceOf(StreamCache::class, Streams::make('films')->cache());
    }
}

class FilmCreationRepository extends Repository
{
    public function create(array $attributes): EntryInterface
    {
        $attributes['title'] = 'Repository: '.$attributes['title'];

        return parent::create($attributes);
    }
}
