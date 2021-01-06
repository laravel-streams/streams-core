<?php

namespace Streams\Core\Tests\Field\Type;

use Tests\TestCase;
use Streams\Core\Support\Facades\Streams;

class MultiselectTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/litmus.json'));
    }

    public function testCasting()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');

        $this->assertSame(['foo', 'bar'], $test->multiselect);
    }
}
