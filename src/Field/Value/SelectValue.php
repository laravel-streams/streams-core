<?php

namespace Streams\Core\Field\Value;

class SelectValue extends Value
{

    public function option()
    {
        return '@todo - ' . __METHOD__ . ' - ' . $this->value;
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
