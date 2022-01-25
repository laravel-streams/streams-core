<?php

namespace Streams\Core\Tests\Field\Types;

use Tests\TestCase;
use Streams\Core\Entry\Entry;
use Streams\Core\Support\Facades\Streams;

class PolymorphicFieldTypeTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/litmus.json'));
        Streams::load(base_path('vendor/streams/core/tests/fakers.json'));
        Streams::load(base_path('vendor/streams/core/tests/examples.json'));
    }

    public function test_restores_as_instance()
    {
        $this->markTestIncomplete('Polymorphic is not ready.');
        return;

        $test = Streams::repository('testing.litmus')->find('field_types');

        $this->assertSame('first', $test->relationship->id);
    }

    public function test_expands_as_instance()
    {
        $this->markTestIncomplete('Polymorphic is not ready.');
        return;
        
        $test = Streams::repository('testing.litmus')->find('field_types');

        $this->assertInstanceOf(Entry::class, $test->expand('relationship'));
        $this->assertSame('First Example', $test->expand('relationship')->name);
    }
}
