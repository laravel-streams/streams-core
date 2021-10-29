<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\Factory\EmailGenerator;
use Streams\Core\Field\Value\EmailValue;

class Email extends Str
{
    
    /**
     * @param $value
     * @return EmailValue
     */
    public function expand($value)
    {
        return new EmailValue($value);
    }

    public function generator(): EmailGenerator
    {
        return new EmailGenerator($this);
    }
}
