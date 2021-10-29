<?php

namespace Streams\Core\Field\Factory;

class MultiselectGenerator extends Generator
{
    public function create()
    {
        $values = [];

        $keys = array_keys($this->field->options());

        for ($i = 1; $i <= $this->faker()->numberBetween(1, count($keys)); $i++) {
            $values[] = $this->faker()->randomElement($keys);
        }

        return $values;
    }
}
