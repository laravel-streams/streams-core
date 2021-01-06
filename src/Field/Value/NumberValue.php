<?php

namespace Streams\Core\Field\Value;

class NumberValue extends Value
{

    /**
     * Return if the number is even.
     *
     * @return bool
     */
    public function isEven()
    {
        return $this->value % 2 == 0;
    }

    /**
     * Return if the number is odd.
     *
     * @return bool
     */
    public function isOdd()
    {
        return $this->value % 2 != 0;
    }
}
