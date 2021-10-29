<?php

namespace Streams\Core\Field\Factory;

class EmailGenerator extends Generator
{
    public function create()
    {
        return $this->faker()->email();
    }
}
