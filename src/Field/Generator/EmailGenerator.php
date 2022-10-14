<?php

namespace Streams\Core\Field\Generator;

use Streams\Core\Field\FieldGenerator;

class EmailGenerator extends FieldGenerator
{
    public function generate()
    {
        return $this->faker->email();
    }
}
