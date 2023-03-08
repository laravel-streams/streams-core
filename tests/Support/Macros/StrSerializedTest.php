<?php

namespace Streams\Core\Tests\Support\Macros;

use Illuminate\Support\Str;
use Streams\Core\Entry\Entry;
use Streams\Core\Tests\CoreTestCase;

class StrSerializedTest extends CoreTestCase
{
    public function test_it_detects_serialized_strings()
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
