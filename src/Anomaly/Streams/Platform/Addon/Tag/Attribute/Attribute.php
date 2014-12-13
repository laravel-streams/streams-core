<?php namespace Anomaly\Streams\Platform\Addon\Tag\Attribute;

class Attribute
{
    protected $name;

    protected $value;

    public function __construct($name, $value)
    {
        $this->name  = $name;
        $this->value = $value;
    }

    public function toArray($itemDelimiter = '|', $valueDelimiter = '=')
    {
        $array = [];

        $values = explode($itemDelimiter, $this->value);

        foreach ($values as $k => $item) {

            $item = explode($valueDelimiter, $item);

            // If there is no key - use the original index.
            $array[count($item) > 1 ? $item[0] : $k] = count($item) > 1 ? $item[1] : $item[0];
        }

        return $array;
    }

    public function bool()
    {
        return filter_var($this->value, FILTER_VALIDATE_BOOLEAN);
    }

    public function __toString()
    {
        return $this->value;
    }
}
