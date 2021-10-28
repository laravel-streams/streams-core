<?php

namespace Streams\Core\Field\Factory;

use Streams\Core\Field\Field;
use Faker\Factory as FakerFactory;
use Illuminate\Support\Traits\Macroable;

class Factory
{
    use Macroable;

    protected Field $field;

    public function __construct(Field $field)
    {
        $this->field = $field;
    }

    public function create()
    {
        return $this->generator()->text(10);
    }

    public function generator()
    {
        return FakerFactory::create();
    }
}
