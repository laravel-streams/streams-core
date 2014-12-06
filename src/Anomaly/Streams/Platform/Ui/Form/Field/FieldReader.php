<?php namespace Anomaly\Streams\Platform\Ui\Form\Field;

class FieldReader
{

    public function convert($key, $value)
    {
        if (is_string($value)) {

            $value = ['field' => $value];
        }

        return $value;
    }
}
 