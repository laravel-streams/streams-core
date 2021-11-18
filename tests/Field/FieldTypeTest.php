<?php

namespace Streams\Core\Tests\Field;

use Tests\TestCase;
use Streams\Core\Field\Value\Value;
use Streams\Core\Support\Facades\Streams;

class FieldTypeTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/fakers.json'));
    }

    public function testGenerateValue()
    {
        $fake = Streams::make('testing.fakers')->fields->string->type()->generate();

        $this->assertIsString($fake);
    }
}
