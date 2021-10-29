<?php

namespace Streams\Core\Field\Factory;

class DateGenerator extends DatetimeGenerator
{
    public function create()
    {
        return $this->faker()->date();
    }
}
