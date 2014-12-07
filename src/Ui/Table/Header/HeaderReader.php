<?php namespace Anomaly\Streams\Platform\Ui\Table\Header;

class HeaderReader
{

    public function convert($key, $value)
    {
        if (is_string($value)) {

            $value = ['text' => $value];
        }

        return $value;
    }
}
 