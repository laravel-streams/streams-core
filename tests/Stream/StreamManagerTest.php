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

    public function test_throws_exception_if_stream_is_not_registed()
    {
        $this->expectException(\Exception::class);

        Streams::make('foo.bar');
    }

    public function test_streams_can_be_registered()
    {
        $stream = Streams::register([
            'id' => 'testing.widgets',
            'fields' => [
                'name' => 'string',
            ]
        ]);

        $this->assertInstanceOf(Stream::class, $stream);

        $this->assertTrue(Streams::has('testing.widgets'));
    }

    // public function testCanMakeRegisteredStreams()
    // {
    //     $this->assertTrue(Streams::has('testing.widgets'));
    //     $this->assertTrue(Streams::has('testing.examples'));

    //     $this->assertInstanceOf(Stream::class, Streams::make('testing.widgets'));
    //     $this->assertInstanceOf(Stream::class, Streams::make('testing.examples'));

    //     $this->assertTrue(Streams::entries('testing.widgets')->get()->isNotEmpty());
    //     $this->assertTrue(Streams::entries('testing.examples')->get()->isNotEmpty());
    // }

    // public function testCanBuildStreamWithoutRegistering()
    // {
    //     $runtime = Streams::build([
    //         'handle' => 'testing.runtime',
    //         'source' => [
    //             'path' => 'vendor/streams/core/tests/data/runtime',
    //             'format' => 'json',
    //         ],
    //         'fields' => [
    //             'name' => 'string',
    //         ],
    //     ]);

    //     $json = Streams::build(json_decode(file_get_contents(base_path('vendor/streams/core/tests/build.json')), true));

    //     $this->assertFalse(Streams::has('testing.runtime'));
    //     $this->assertFalse(Streams::has('testing.build'));

    //     $this->assertInstanceOf(Stream::class, $runtime);
    //     $this->assertInstanceOf(Stream::class, $json);
    // }

    // public function testCollectsRegisteredStreams()
    // {
    //     $this->assertTrue(Streams::collection()->isNotEmpty());

    //     $this->assertInstanceOf(Collection::class, Streams::collection());
    // }

    // public function testCanReturnStreamEntryCriteria()
    // {
    //     $this->assertInstanceOf(Criteria::class, Streams::entries('testing.examples'));
    // }

    // public function testCanReturnStreamEntryRepository()
    // {
    //     $this->assertInstanceOf(RepositoryInterface::class, Streams::repository('testing.examples'));
    // }
}
