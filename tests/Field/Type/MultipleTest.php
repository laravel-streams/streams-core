<?php

namespace Streams\Core\Tests\Field\Type;

use Tests\TestCase;
use Streams\Core\Entry\Entry;
use Illuminate\Support\Collection;
use Streams\Core\Support\Facades\Streams;

class MultipleTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/litmus.json'));
        Streams::load(base_path('vendor/streams/core/tests/fakers.json'));
        Streams::load(base_path('vendor/streams/core/tests/examples.json'));
    }

    public function testCasting()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');

        $this->assertSame(['first', 'second'], $test->multiple);
        $this->assertInstanceOf(Collection::class, $test->expand('multiple'));
        $this->assertInstanceOf(Entry::class, $test->expand('multiple')->last());
        $this->assertSame('First Example', $test->expand('multiple')->first()->name);
    }
}
