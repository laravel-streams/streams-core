<?php

namespace Streams\Core\Tests\Field;

use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Types\IntegerFieldType;

class FieldDecoratorTest extends CoreTestCase
{
    public function test_it_can_set_and_get_field()
    {
        $field = new IntegerFieldType([
            'foo' => 'bar',
            'stream' => Streams::make('films')
        ]);

        $this->assertSame('bar', $field->decorate('100')->getField()->foo);
        $this->assertSame(100, $field->decorate(100)->getValue());
    }

    public function test_it_supports_to_string()
    {
        $field = new IntegerFieldType();

        $this->assertSame('100', (string) $field->decorate(100));
    }
}
