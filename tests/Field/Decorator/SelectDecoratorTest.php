<?php

namespace Streams\Core\Tests\Field\Decorator;

use Streams\Core\Image\Image;
use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Types\SelectFieldType;

class SelectDecoratorTest extends CoreTestCase
{
    public function test_it_checks_even_and_odd()
    {
        $field = new  SelectFieldType([
            'stream' => Streams::make('films'),
            'config' => [
                'options' => [
                    'foo' => 'Foo',
                    'bar' => 'Bar'
                ],
            ],
        ]);

        $decorator = $field->decorate('bar');

        $this->assertSame('Bar', (string) $decorator);
        $this->assertSame('Bar', $decorator->text());

        $decorator->value = null;

        $this->assertNull($decorator->text());
    }
}
