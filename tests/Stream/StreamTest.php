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
