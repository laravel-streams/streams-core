<?php

namespace Streams\Core\Tests\Entry;

use Tests\TestCase;
use Streams\Core\Entry\Entry;
use Streams\Core\Stream\Stream;
use Streams\Core\Support\Facades\Streams;

class EntryFactoryTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/fakers.json'));
    }

    public function tearDown(): void
    {
        $this->createApplication();

        Streams::entries('testing.fakers')->truncate();
    }

    public function testCanCreateAFakeEntry()
    {
        $fake = Streams::make('testing.fakers')->factory()->create();

        $this->assertIsString($fake->string);
    }
}
