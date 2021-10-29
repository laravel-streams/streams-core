<?php

namespace Streams\Core\Field\Factory;

class DatetimeGenerator extends Generator
{
    public function create()
    {
        return $this->faker()->dateTime();
    }
}
