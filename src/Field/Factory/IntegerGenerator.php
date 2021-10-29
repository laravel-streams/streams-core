<?php

namespace Streams\Core\Field\Factory;

class IntegerGenerator extends NumberGenerator
{
    public function create()
    {
        return $this->faker()->randomNumber();
    }
}
