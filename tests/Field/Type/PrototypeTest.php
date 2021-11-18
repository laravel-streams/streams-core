<?php

namespace Streams\Core\Tests\Field\Type;

use Tests\TestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Support\Traits\Prototype;

class PrototypeTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/litmus.json'));
    }

    public function testCasting()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');

        $this->assertInstanceOf(ExampleAbstract::class, $test->expand('object'));
        $this->assertSame('bar', $test->expand('object')->foo);
    }
}

class ExampleAbstract 
{
    use Prototype;
}
