<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\Factory\Factory;

class NumberFactory extends Factory
{

    public function create()
    {
        return $this->generator()->randomNumber();
    }
}
