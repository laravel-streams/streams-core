<?php

namespace Streams\Core\Tests\Field\Type;

use Tests\TestCase;
use Streams\Core\Entry\Entry;
use Illuminate\Support\Collection;
use Streams\Core\Criteria\Criteria;
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

    public function test_restores_to_collection()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');

        $this->assertInstanceOf(Collection::class, $test->multiple);
        $this->assertInstanceOf(Entry::class, $test->multiple->last());
        $this->assertSame('First Example', $test->multiple->first()->name);
    }

    public function test_expands_to_criteria()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');

        $this->assertInstanceOf(Criteria::class, $test->expand('multiple'));
    }
}
