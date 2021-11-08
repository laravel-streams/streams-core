<?php

namespace Streams\Core\Tests\Field\Type;

use Tests\TestCase;
use Streams\Core\Entry\Entry;
use Streams\Core\Support\Facades\Streams;

class RelationshipTest extends TestCase
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

        $this->assertSame('first', $test->relationship);
        $this->assertInstanceOf(Entry::class, $test->expand('relationship'));
        $this->assertSame('First Example', $test->expand('relationship')->name);
    }
}
