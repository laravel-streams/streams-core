<?php

namespace Streams\Core\Tests\Stream;

use Tests\TestCase;
use Illuminate\Support\Str;
use Streams\Core\Criteria\Criteria;
use Streams\Core\Stream\StreamCache;
use Streams\Core\Support\Facades\Streams;
use Illuminate\Contracts\Validation\Validator;
use Streams\Core\Repository\Contract\RepositoryInterface;

class StreamCacheTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::register([
            'handle' => 'testing.widgets',
            'source' => [
                'path' => 'vendor/streams/core/tests/data/widgets',
                'format' => 'json',
            ],
            'rules' => [
                'name' => 'required|widget_validator'
            ],
            'validators' => [
                'widget_validator' => [
                    'handler' => 'Streams\Core\Tests\Stream\WidgetValidator@handle',
                    'message' => 'Testing message',
                ],
            ],
            'fields' => [
                'name' => 'string',
            ],
        ]);

        Streams::load(base_path('vendor/streams/core/tests/examples.json'));
    }

    public function testInstantiation()
    {
        $stream = Streams::make('testing.examples');

        $this->assertInstanceOf(StreamCache::class, $stream->cache());
    }

    public function testGet()
    {
        $stream = Streams::make('testing.examples');

        $stream->cache()->flush();
        
        $this->assertNull($stream->cache()->get('test_key'));
        $this->assertEquals('test', $stream->cache()->get('test_key', 'test'));
    }

    public function testPut()
    {
        $stream = Streams::make('testing.examples');

        $stream->cache()->flush();
        
        $stream->cache()->put('test_key', 'test', 3600);

        $this->assertEquals('test', $stream->cache()->get('test_key'));

        $stream->cache()->put('test_key', 'test2', 3600);

        $this->assertEquals('test2', $stream->cache()->get('test_key'));
    }

    public function testAdd()
    {
        $stream = Streams::make('testing.examples');

        $stream->cache()->flush();
        
        $stream->cache()->add('test_key', 'test', 3600);

        $this->assertEquals('test', $stream->cache()->get('test_key'));

        $stream->cache()->add('test_key', 'test2', 3600);

        $this->assertEquals('test', $stream->cache()->get('test_key'));
    }

    public function testHas()
    {
        $stream = Streams::make('testing.examples');

        $stream->cache()->flush();
        
        $this->assertFalse($stream->cache()->has('test_key'));

        $stream->cache()->put('test_key', 'test', 3600);

        $this->assertTrue($stream->cache()->has('test_key'));
    }

    public function testIncrememntals()
    {
        $stream = Streams::make('testing.examples');

        $stream->cache()->flush();
        
        $stream->cache()->put('test_key', 1, 3600);

        $this->assertEquals(1, $stream->cache()->get('test_key'));

        $stream->cache()->increment('test_key');

        $this->assertEquals(2, $stream->cache()->get('test_key'));

        $stream->cache()->increment('test_key', 2);

        $this->assertEquals(4, $stream->cache()->get('test_key'));

        $stream->cache()->decrement('test_key');

        $this->assertEquals(3, $stream->cache()->get('test_key'));

        $stream->cache()->decrement('test_key', 2);

        $this->assertEquals(1, $stream->cache()->get('test_key'));
    }

    public function testRemember()
    {
        $stream = Streams::make('testing.examples');

        $stream->cache()->flush();
        
        $this->assertNull($stream->cache()->get('test_key'));

        $stream->cache()->remember('test_key', 3600, function() {
            return 'remember_this';
        });

        $this->assertEquals('remember_this', $stream->cache()->get('test_key'));

        $stream->cache()->flush();

        $stream->cache()->rememberForever('test_key', function() {
            return 'remember_always';
        });

        $this->assertEquals('remember_always', $stream->cache()->get('test_key'));

        $stream->cache()->flush();

        $stream->cache()->forever('test_key', 'remembered');

        $this->assertEquals('remembered', $stream->cache()->get('test_key'));
    }

    public function testPull()
    {
        $stream = Streams::make('testing.examples');

        $stream->cache()->flush();
        
        $this->assertNull($stream->cache()->get('test_key'));

        $stream->cache()->put('test_key', 'test', 3600);

        $this->assertEquals('test', $stream->cache()->pull('test_key'));
        
        $this->assertFalse($stream->cache()->has('test_key'));
    }
}
