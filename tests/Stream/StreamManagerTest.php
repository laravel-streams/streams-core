<?php

namespace Streams\Core\Tests\Stream;

use Tests\TestCase;
use Streams\Core\Stream\Stream;
use Illuminate\Support\Collection;
use Streams\Core\Criteria\Criteria;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Repository\Contract\RepositoryInterface;

class StreamManagerTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::register([
            'handle' => 'testing.widgets'
        ]);
        
        Streams::register([
            'handle' => 'testing.widgets',
            'route' => 'testing/widgets/{entry}',
            'source' => [
                'path' => 'vendor/streams/core/tests/data/widgets',
                'format' => 'json',
            ],
            'fields' => [
                'name' => 'string',
            ],
        ]);

        Streams::load(base_path('vendor/streams/core/tests/examples.json'));
    }

    public function testCanMakeRegisteredStreams()
    {
        $this->assertTrue(Streams::has('testing.widgets'));
        $this->assertTrue(Streams::has('testing.examples'));

        $this->assertInstanceOf(Stream::class, Streams::make('testing.widgets'));
        $this->assertInstanceOf(Stream::class, Streams::make('testing.examples'));

        $this->assertTrue(Streams::entries('testing.widgets')->get()->isNotEmpty());
        $this->assertTrue(Streams::entries('testing.examples')->get()->isNotEmpty());
    }

    public function testCanBuildStreamWithoutRegistering()
    {
        $runtime = Streams::build([
            'handle' => 'testing.runtime',
            'source' => [
                'path' => 'vendor/streams/core/tests/data/runtime',
                'format' => 'json',
            ],
            'fields' => [
                'name' => 'string',
            ],
        ]);

        $json = Streams::build(json_decode(file_get_contents(base_path('vendor/streams/core/tests/build.json')), true));

        $this->assertFalse(Streams::has('testing.runtime'));
        $this->assertFalse(Streams::has('testing.build'));

        $this->assertInstanceOf(Stream::class, $runtime);
        $this->assertInstanceOf(Stream::class, $json);
    }

    public function testCollectsRegisteredStreams()
    {
        $this->assertTrue(Streams::collection()->isNotEmpty());

        $this->assertInstanceOf(Collection::class, Streams::collection());
    }

    public function testCanReturnStreamEntryCriteria()
    {
        $this->assertInstanceOf(Criteria::class, Streams::entries('testing.examples'));
    }

    public function testCanReturnStreamEntryRepository()
    {
        $this->assertInstanceOf(RepositoryInterface::class, Streams::repository('testing.examples'));
    }
}
