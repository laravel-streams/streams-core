<?php

namespace Streams\Core\Field\Factory;

class BooleanGenerator extends Generator
{
    public function create()
    {
        return (bool) $this->generator()->numberBetween(0, 1);
    }
}
