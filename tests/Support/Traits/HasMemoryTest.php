<?php

namespace Streams\Core\Tests\Support\Traits;

use Tests\TestCase;
use Streams\Core\Support\Traits\HasMemory;

class HasMemoryTest extends TestCase
{

    public function test_can_remember_things()
    {
        $instance = new MemoryTestClass;

        $value = $instance->remember('test', function () {
            return 'Test';
        });

        $this->assertSame('Test', $value);

        $value = $instance->remember('test', function () {
            return 'Different';
        });

        $this->assertSame('Test', $value);
    }

    public function test_can_inherit_memory()
    {
        $instance = new AnotherMemoryTestClass;

        $value = $instance->once('test', function () {
            return 'Test';
        });

        $this->assertSame('Test', $value);

        $instance = new MemoryTestClass;

        $value = $instance->once('test', function () {
            return 'Different';
        });

        $this->assertSame('Test', $value);
    }

    public function test_can_forget_things()
    {
        $instance = new MemoryTestClass;

        $value = $instance->remember('test', function () {
            return 'Test';
        });

        $this->assertSame('Test', $value);

        $instance->forget('test');

        $value = $instance->remember('test', function () {
            return 'Different';
        });

        $this->assertSame('Different', $value);
    }

    public function test_can_forget_everything()
    {
        $instance = new MemoryTestClass;

        $value = $instance->remember('forget_everything', function () {
            return 'Test';
        });

        $this->assertSame('Test', $value);

        $instance->resetMemory();

        $value = $instance->remember('forget_everything', function () {
            return 'Different';
        });

        $this->assertSame('Different', $value);
    }
}

class MemoryTestClass
{
    use HasMemory;
}

class AnotherMemoryTestClass extends MemoryTestClass
{
}
