<?php

namespace Streams\Core\Field\Factory;

class StrGenerator extends Generator
{
    public function create()
    {
        return $this->faker()->text();
    }
}
