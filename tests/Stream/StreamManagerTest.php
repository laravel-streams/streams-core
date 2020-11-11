<?php

namespace Streams\Core\Tests\Stream;

use Tests\TestCase;
use Streams\Core\Stream\Stream;
use Streams\Core\Support\Facades\Streams;

class StreamManagerTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::register([
            'handle' => 'testing.examples',
            'source' => [
                'path' => 'vendor/streams/core/tests/streams/data/examples',
                'format' => 'json',
            ],
            'fields' => [
                'name' => 'string',
            ],
        ]);

        Streams::load(base_path('vendor/streams/core/tests/streams/widgets.json'));
    }

    public function testCanMakeRegisteredStreams()
    {
        $this->assertTrue(Streams::has('testing.examples'));
        $this->assertTrue(Streams::has('testing.widgets'));
        
        $this->assertInstanceOf(Stream::class, Streams::make('testing.examples'));
        $this->assertInstanceOf(Stream::class, Streams::make('testing.widgets'));
    }
    
    public function testCanBuildStreamWithoutRegistering()
    {
        $stream = Streams::build([
            'handle' => 'testing.runtime',
            'source' => [
                'path' => 'vendor/streams/core/tests/streams/data/runtime',
                'format' => 'json',
            ],
            'fields' => [
                'name' => 'string',
            ],
        ]);

        $this->assertFalse(Streams::has('testing.runtime'));
        
        $this->assertInstanceOf(Stream::class, $stream);
    }
}
