<?php

namespace Streams\Core\Tests\Field\Decorator;

use Streams\Core\Image\Image;
use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Types\MultiselectFieldType;

class MultiselectDecoratorTest extends CoreTestCase
{
    public function test_it_checks_even_and_odd()
    {
        $field = new  MultiselectFieldType([
            'stream' => Streams::make('films'),
            'config' => [
                'options' => [
                    'foo' => 'Foo',
                    'bar' => 'Bar'
                ],
            ],
        ]);

        $decorator = $field->decorate(['bar']);

        $this->assertSame(['bar' => 'Bar'], $decorator->selected());

        $decorator->value = null;

        $this->assertNull($decorator->selected());
    }
}
