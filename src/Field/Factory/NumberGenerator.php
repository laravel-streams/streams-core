<?php

namespace Streams\Core\Field\Factory;

class NumberGenerator extends Generator
{
    public function create()
    {
        return $this->faker()->randomNumber();
    }
}
