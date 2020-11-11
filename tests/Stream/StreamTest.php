<?php

namespace Streams\Core\Tests\Stream;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Collection;
use Streams\Core\Criteria\Contract\CriteriaInterface;
use Streams\Core\Repository\Contract\RepositoryInterface;
use Tests\TestCase;
use Streams\Core\Stream\Stream;
use Streams\Core\Support\Facades\Streams;

class StreamTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/widgets.json'));
    }

    public function testSupportInterfaces()
    {
        $this->assertIsArray(Streams::make('testing.widgets')->toArray());
        $this->assertJson(Streams::make('testing.widgets')->toJson());
        $this->assertJson((string) Streams::make('testing.widgets'));
    }

    public function testCanReturnEntryCriteria()
    {
        $this->assertInstanceOf(CriteriaInterface::class, Streams::make('testing.widgets')->entries());
    }

    public function testCanReturnEntryRepository()
    {
        $this->assertInstanceOf(RepositoryInterface::class, Streams::make('testing.widgets')->repository());
    }

    public function testStreamValidator()
    {
        $this->assertInstanceOf(Validator::class, Streams::make('testing.widgets')->validator([]));

        $this->assertFalse(Streams::make('testing.widgets')->validator([])->passes());
        $this->assertTrue(Streams::make('testing.widgets')->validator(['name' => 'Test'])->passes());

        $entry = Streams::entries('testing.widgets')->first();

        $this->assertTrue(Streams::make('testing.widgets')->validator($entry)->passes());

        $entry->name = null;

        $this->assertFalse(Streams::make('testing.widgets')->validator($entry)->passes());
    }
}
