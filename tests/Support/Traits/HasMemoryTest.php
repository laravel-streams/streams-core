<?php

namespace Streams\Core\Tests\Support\Traits;

use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Traits\HasMemory;

class HasMemoryTest extends CoreTestCase
{

    public function test_it_remembers_things()
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

        $value = $instance->once('test_once', function () {
            return 'Test';
        });

        $this->assertSame('Test', $value);

        $value = $instance->once('test_once', function () {
            return 'Different';
        });

        $this->assertSame('Test', $value);
    }

    public function test_it_inherits_memory()
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

    public function test_it_forgets_things()
    {
        $instance = new MemoryTestClass;

        $instance->remember('test', function () {
            return 'Test';
        });

        $instance->forget('test');

        $value = $instance->remember('test', function () {
            return 'Different';
        });

        $this->assertSame('Different', $value);

        $instance->once('test_once', function () {
            return 'Test';
        });

        $instance->forget('test_once');

        $value = $instance->once('test_once', function () {
            return 'Different';
        });

        $this->assertSame('Different', $value);
    }

    public function test_it_resets_memory()
    {
        $instance = new MemoryTestClass;

        $instance->remember('forget_me', function () {
            return 'Test';
        });

        $instance->once('forget_once', function () {
            return 'Test Once';
        });

        $instance->resetMemory();

        $value = $instance->remember('forget_me', function () {
            return 'Different';
        });

        $this->assertSame('Different', $value);

        $value = $instance->once('forget_once', function () {
            return 'Test Value';
        });

        $this->assertSame('Test Value', $value);
    }
}

class MemoryTestClass
{
    use HasMemory;
}

class AnotherMemoryTestClass extends MemoryTestClass
{
}
