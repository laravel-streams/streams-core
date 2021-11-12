<?php

namespace Streams\Core\Tests\Support\Traits;

use Tests\TestCase;
use Illuminate\Support\Str;
use Streams\Core\Entry\Entry;
use Illuminate\Support\Facades\App;

class StrMacrosTest extends TestCase
{

    public function test_can_humanize_strings()
    {
        $this->assertSame('foo bar', Str::humanize('foo_bar'));
        $this->assertSame('foo bar', Str::humanize('foo-bar', '-'));
    }

    public function test_can_parse_strings()
    {
        $this->assertSame(env('APP_URL'), Str::parse('{request.url}'));
        $this->assertSame(App::getLocale(), Str::parse('{app.locale}'));
    }

    public function test_can_truncate_strings()
    {
        $this->assertSame('Test...', Str::truncate('Test me!', 4));
        $this->assertSame('Test me!', Str::truncate('Test me!', 10));
    }

    public function test_can_detect_serialized_strings()
    {
        $this->assertFalse(Str::isSerialized('Foo'));
        $this->assertFalse(Str::isSerialized('Foo Bar'));
        $this->assertTrue(Str::isSerialized(serialize(null)));
        $this->assertTrue(Str::isSerialized(serialize(true)));
        $this->assertTrue(Str::isSerialized(serialize(10.00)));
        $this->assertTrue(Str::isSerialized(serialize('Testing')));
        $this->assertTrue(Str::isSerialized(serialize(new Entry(['foo' => 'bar']))));
        
        $this->assertTrue(Str::isSerialized(serialize(new Entry(['foo' => 'bar'])), false));
        $this->assertTrue(Str::isSerialized(serialize(new Entry(['foo' => 'bar'])), false));
    }
}
