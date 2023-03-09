<?php

namespace Streams\Core\Tests\Field\Decorator;

use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Types\DateFieldType;

class DatetimeDecoratorTest extends CoreTestCase
{
    public function test_it_returns_boolean()
    {
        $field = new DateFieldType([
            'stream' => Streams::make('films')
        ]);

        $decorator = $field->decorate($field->cast('2021-01-01'));

        $this->assertSame('2021-01-01', $decorator->format('Y-m-d'));
    }
}
