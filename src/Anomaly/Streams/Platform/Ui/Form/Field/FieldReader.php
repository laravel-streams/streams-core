<?php namespace Anomaly\Streams\Platform\Ui\Form\Field;

class FieldReader
{

    public function convert($key, $parameters)
    {
        if (is_string($parameters)) {

            $parameters = ['field' => $parameters];
        }
    }
}
 