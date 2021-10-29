<?php

namespace Streams\Core\Field\Factory;

class TimeGenerator extends DatetimeGenerator
{
    public function create()
    {
        return $this->faker()->time();
    }
}
