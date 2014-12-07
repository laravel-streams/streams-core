<?php namespace Anomaly\Streams\Platform\Ui\Table\Column;

use Anomaly\Streams\Platform\Ui\Table\Header\HeaderReader;

class ColumnReader
{

    protected $headerReader;

    function __construct(HeaderReader $headerReader)
    {
        $this->headerReader = $headerReader;
    }

    public function convert($key, $value)
    {
        /**
         * If the key is numeric and the value is not
         * an array then use the value as the value.
         */
        if (!is_array($value)) {

            $value = [
                'header' => $value,
                'value'  => $value,
            ];
        }

        /**
         * If the value header is set but is a string
         * convert it into the header's text.
         */
        if (is_array($value) and isset($value['header']) and is_string($value['header'])) {

            $value['header'] = $this->headerReader->convert(0, $value['header']);
        }

        return $value;
    }
}
 