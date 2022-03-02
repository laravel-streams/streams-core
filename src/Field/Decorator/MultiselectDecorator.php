<?php

namespace Streams\Core\Field\Decorator;

use Streams\Core\Field\FieldDecorator;

class MultiselectDecorator extends FieldDecorator
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
