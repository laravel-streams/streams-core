<?php

namespace Streams\Core\Field\Factory;

class UrlGenerator extends StrGenerator
{
    public function create()
    {
        return $this->faker()->url();
    }
}
