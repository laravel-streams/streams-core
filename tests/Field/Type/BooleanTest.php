<?php

namespace Streams\Core\Tests\Field\Type;

use Tests\TestCase;
use Streams\Core\Support\Facades\Streams;

class BooleanTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/litmus.json'));
    }

    public function testCasting()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');
        
        $this->assertSame(true, $test->boolean);

        $test->boolean = 'no';

        $this->assertSame(false, $test->boolean);

        $test->boolean = 1;

        $this->assertSame(true, $test->boolean);
    }
}
