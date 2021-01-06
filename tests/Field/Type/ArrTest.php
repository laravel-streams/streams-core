<?php

namespace Streams\Core\Tests\Field\Type;

use Streams\Core\Field\Value\ArrValue;
use Tests\TestCase;
use Streams\Core\Support\Facades\Streams;

class ArrTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/litmus.json'));
    }

    public function testCasting()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');

        $this->assertSame(['foo' => 'bar'], $test->array);
    }

    public function testExpandedValue()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');
        
        $this->assertInstanceOf(ArrValue::class, $test->expand('array'));
    }
}
