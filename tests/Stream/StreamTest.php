<?php

namespace Streams\Core\Tests\Stream;

use Streams\Core\Criteria\Criteria;
use Streams\Core\Stream\StreamCache;
use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Stream\StreamSchema;
use Streams\Core\Repository\Repository;
use Streams\Core\Support\Facades\Streams;
use Illuminate\Contracts\Validation\Validator;

class StreamTest extends CoreTestCase
{
    public function test_it_creates_custom_fixtures_and_restores_committed_data()
    {
        $stream = Streams::make('films');
        $entry = $stream->create(['title' => 'Custom Fixture', 'director' => 'Test Director']);

        $this->assertNotNull($entry->id);
        $this->assertSame('Test Director', $stream->entries()->find($entry->id)->director);
        $this->assertSame(8, $stream->entries()->count());

        $this->restoreStreamsData();

        $this->assertSame(7, $stream->entries()->count());
        $this->assertNull($stream->entries()->where('title', 'Custom Fixture')->first());
    }

    public function test_it_validates_required_fields_before_creating_an_entry()
    {
        $stream = Streams::make('films');

        try {
            $stream->create(['director' => 'Test Director']);
            $this->fail('Creation should reject a missing required title.');
        } catch (\Illuminate\Validation\ValidationException $exception) {
            $this->assertArrayHasKey('title', $exception->errors());
            $this->assertSame(7, $stream->entries()->count());
        }
    }

    public function test_creation_does_not_ignore_unique_rules_for_an_existing_id()
    {
        $this->expectException(\Illuminate\Validation\ValidationException::class);

        Streams::make('films')->create(['episode_id' => 4, 'title' => 'A New Hope']);
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
