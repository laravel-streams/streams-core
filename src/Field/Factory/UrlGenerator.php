<?php

namespace Streams\Core\Field\Factory;

class UrlGenerator extends Generator
{
    public function create()
    {
        return $this->faker()->url();
    }
}
