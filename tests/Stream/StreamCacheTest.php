<?php

namespace Streams\Core\Tests\Stream;

use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;
class StreamCacheTest extends CoreTestCase
{
    public function test_it_returns_default_results()
    {
        $stream = Streams::make('films');

        $this->assertNull($stream->cache()->get('test_key'));
        $this->assertEquals('test', $stream->cache()->get('test_key', 'test'));
    }

    public function test_it_puts_items_into_store()
    {
        $stream = Streams::make('films');

        $stream->cache()->put('test_key', 'test', 3600);

        $this->assertEquals('test', $stream->cache()->get('test_key'));
    }

    public function test_it_puts_items_into_store_forever()
    {
        $stream = Streams::make('films');

        $stream->cache()->forever('test_key', 'test');

        $this->assertEquals('test', $stream->cache()->get('test_key'));
    }

    public function test_it_adds_items_only_if_not_set()
    {
        $stream = Streams::make('films');

        $stream->cache()->flush();
        
        $stream->cache()->add('test_key', 'test', 3600);

        $this->assertEquals('test', $stream->cache()->get('test_key'));

        $stream->cache()->add('test_key', 'test2', 3600);

        $this->assertEquals('test', $stream->cache()->get('test_key'));
    }

    public function test_it_detects_cache_keys()
    {
        $stream = Streams::make('films');

        $this->assertFalse($stream->cache()->has('test_key'));

        $stream->cache()->put('test_key', 'test', 3600);

        $this->assertTrue($stream->cache()->has('test_key'));
    }

    public function test_it_increments_cached_values()
    {
        $stream = Streams::make('films');

        $stream->cache()->put('test_key', 1, 3600);

        $stream->cache()->increment('test_key');

        $this->assertEquals(2, $stream->cache()->get('test_key'));

        $stream->cache()->increment('test_key', 2);

        $this->assertEquals(4, $stream->cache()->get('test_key'));
    }

    public function test_it_decrements_cached_values()
    {
        $stream = Streams::make('films');

        $stream->cache()->put('test_key', 4, 3600);

        $stream->cache()->decrement('test_key');

        $this->assertEquals(3, $stream->cache()->get('test_key'));

        $stream->cache()->decrement('test_key', 2);

        $this->assertEquals(1, $stream->cache()->get('test_key'));
    }

    public function test_it_remembers_values()
    {
        $stream = Streams::make('films');

        $this->assertNull($stream->cache()->get('test_key'));

        $stream->cache()->remember('test_key', 3600, function() {
            return 'remember_this';
        });

        $this->assertEquals('remember_this', $stream->cache()->get('test_key'));
    }

    public function test_it_remembers_forever()
    {
        $stream = Streams::make('films');

        $this->assertNull($stream->cache()->get('test_key'));

        $stream->cache()->rememberForever('test_key', function() {
            return 'remember_this';
        });

        $this->assertEquals('remember_this', $stream->cache()->get('test_key'));
    }

    public function test_it_pulls_values_out_of_store()
    {
        $stream = Streams::make('films');

        $this->assertNull($stream->cache()->get('test_key'));

        $stream->cache()->put('test_key', 'test', 3600);

        $this->assertEquals('test', $stream->cache()->pull('test_key'));
        
        $this->assertFalse($stream->cache()->has('test_key'));
    }

    public function test_it_can_forget_items()
    {
        $stream = Streams::make('films');

        $stream->cache()->remember('test_key', 3600, function() {
            return 'remember_this';
        });

        $this->assertEquals('remember_this', $stream->cache()->get('test_key'));

        $stream->cache()->forget('test_key');

        $this->assertEquals(null, $stream->cache()->get('test_key'));
    }
    
    public function test_it_can_flush_items()
    {
        $stream = Streams::make('films');

        $stream->cache()->remember('test_key', 3600, function() {
            return 'remember_this';
        });

        $this->assertEquals('remember_this', $stream->cache()->get('test_key'));

        $stream->cache()->flush();

        $this->assertEquals(null, $stream->cache()->get('test_key'));
    }
}
