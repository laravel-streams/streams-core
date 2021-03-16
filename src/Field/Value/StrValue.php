<?php

namespace Streams\Core\Field\Value;

class StrValue extends Value
{

    public function lines()
    {
        return explode("\n", $this->value);
    }

    /**
     * Normalize the URL by default.
     *
     * @return bool|string
     */
    public function __toString()
    {
        return (string) $this->value;
    }
}
