<?php namespace Streams\Core\Tests\Stream;

class ExampleValidator
{

    public function validate($attribute, $value)
    {
        return strpos($value, 'First') > -1;
    }
}
