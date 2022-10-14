<?php

namespace Streams\Core\Field;

use Faker\Generator;
use Streams\Core\Field\Field;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Traits\Macroable;

abstract class FieldGenerator
{
    use Macroable;

    protected Field $field;

    protected Generator $faker;

    public function __construct(Field $field)
    {
        $this->field = $field;

        $this->faker = App::make('faker');
    }

    abstract public function generate();
}
