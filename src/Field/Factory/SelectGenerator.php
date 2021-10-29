<?php

namespace Streams\Core\Field\Factory;

class SelectGenerator extends Generator
{
    public function create()
    {
        return $this->faker()->randomElement(array_keys($this->field->options()));
    }
}
