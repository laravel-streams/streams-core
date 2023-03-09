<?php

namespace Streams\Core\Tests\Field\Decorator;

use Streams\Core\Image\Image;
use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Types\HashFieldType;

class HashDecoratorTest extends CoreTestCase
{
    public function test_it_checks_against_hashed_value()
    {
        $field = new HashFieldType([
            'stream' => Streams::make('films')
        ]);

        $decorator = $field->decorate($field->cast('I am a secret'));

        $this->assertTrue($decorator->check('I am a secret'));
        $this->assertFalse($decorator->check('I am not a secret'));
    }
}
