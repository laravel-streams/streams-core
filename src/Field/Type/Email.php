<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\Value\EmailValue;

class Email extends Str
{
    
    /**
     * Expand the value.
     *
     * @param $value
     * @return EmailValue
     */
    public function expand($value)
    {
        return new EmailValue($value);
    }
}
