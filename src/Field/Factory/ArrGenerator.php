<?php

namespace Streams\Core\Field\Factory;

class ArrGenerator extends Generator
{
    public function create()
    {
        for ($i = 0; $i < 10; $i++) {
            $values[] = $this->faker()->text(10);
        }

        return $values;
    }
}
