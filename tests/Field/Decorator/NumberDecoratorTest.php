<?php

namespace Streams\Core\Tests\Field\Decorator;

use Streams\Core\Image\Image;
use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Types\NumberFieldType;

class NumberDecoratorTest extends CoreTestCase
{
    public function test_it_checks_even_and_odd()
    {
        $field = new NumberFieldType([
            'stream' => Streams::make('films')
        ]);

        $decorator = $field->decorate(3);

        $this->assertTrue($decorator->isOdd());
        $this->assertFalse($decorator->isEven());
    }
}
