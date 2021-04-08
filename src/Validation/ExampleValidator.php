<?php namespace Streams\Core\Validation;

class ExampleValidator
{

    public function validate($attribute, $value)
    {
        return strpos($value, 'First') > -1;
    }
}
