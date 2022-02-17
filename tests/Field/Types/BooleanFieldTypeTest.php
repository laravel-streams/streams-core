<?php

namespace Streams\Core\Tests\Field\Types;

use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Value\BooleanValue;
use Streams\Core\Field\Types\BooleanFieldType;

class BooleanFieldTypeTest extends CoreTestCase
{
    public function test_it_returns_boolean_value()
    {
        $field = new BooleanFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertInstanceOf(BooleanValue::class, $field->expand(true));
    }
}
