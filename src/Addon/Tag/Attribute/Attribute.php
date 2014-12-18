<?php namespace Anomaly\Streams\Platform\Addon\Tag\Attribute;

/**
 * Class Attribute
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Tag\Attribute
 */
class Attribute
{

    /**
     * The attribute's name.
     *
     * @var
     */
    protected $name;

    /**
     * The attribute's value.
     *
     * @var
     */
    protected $value;

    /**
     * Create a new Attribute instance.
     *
     * @param $name
     * @param $value
     */
    public function __construct($name, $value)
    {
        $this->name  = $name;
        $this->value = $value;
    }

    /**
     * Get the attribute's value parsed to an array.
     *
     * @param  string $itemDelimiter
     * @param  string $valueDelimiter
     * @return array
     */
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

    /**
     * Get the attribute's value.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Get the attribute's name.
     *
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Return the value as a boolean.
     *
     * @return mixed
     */
    public function bool()
    {
        return filter_var($this->value, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Return the value as a string.
     *
     * @return string
     */
    public function string()
    {
        return (string)$this->value;
    }

    /**
     * Return the value as a URL.
     *
     * @return string
     */
    public function url()
    {
        $url = $this->value;

        if (!str_contains('http', $url)) {
            $url = url($url);
        }

        return $url;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->value;
    }
}
