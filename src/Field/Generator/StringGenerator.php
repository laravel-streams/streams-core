<?php

namespace Streams\Core\Field\Decorator;

use Streams\Core\Field\FieldGenerator;

class StringGenerator extends FieldGenerator
{
    public function generate()
    {
        return $this->faker->text($this->field->config('max'));
    }
}
