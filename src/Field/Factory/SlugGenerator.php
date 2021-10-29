<?php

namespace Streams\Core\Field\Factory;

class SlugGenerator extends Generator
{
    public function create()
    {
        return $this->field->modify($this->faker()->text(rand(15, 25)));
    }
}
