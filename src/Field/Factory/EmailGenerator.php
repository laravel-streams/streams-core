<?php

namespace Streams\Core\Field\Factory;

class EmailGenerator extends StrGenerator
{
    public function create()
    {
        return $this->faker()->email();
    }
}
