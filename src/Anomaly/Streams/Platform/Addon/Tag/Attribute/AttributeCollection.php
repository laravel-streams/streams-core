<?php namespace Anomaly\Streams\Platform\Addon\Tag\Attribute;

use Illuminate\Support\Collection;

/**
 * Class AttributeCollection
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Tag\Attribute
 */
class AttributeCollection extends Collection
{
    /**
     * Create a new AttributeCollection instance.
     *
     * @param array $attributes
     */
    public function __construct($attributes = array())
    {
        foreach ($attributes as $key => $value) {
            $this->items[$key] = new Attribute($key, $value);
        }
    }

    /**
     * Return attributes except where
     * names appear in keys argument.
     *
     * @param $keys
     * @return static
     */
    public function except($keys)
    {
        $items = array_except($this->allValues(), $keys);

        return new static($items);
    }

    /**
     * Get an attribute.
     *
     * @param mixed $key
     * @param null  $default
     * @return Attribute|mixed
     */
    public function get($key, $default = null)
    {
        $value = parent::get($key, $default);

        if (!$value instanceof Attribute) {

            $value = new Attribute($key, $value);
        }

        return $value;
    }

    /**
     * Get an attribute's value.
     *
     * @param      $key
     * @param null $default
     * @return mixed
     */
    public function getValue($key, $default = null)
    {
        $attribute = $this->get($key, $default);

        return $attribute->getValue();
    }

    /**
     * Get an attribute value cast to a string.
     *
     * @param      $key
     * @param null $default
     * @return string
     */
    public function getString($key, $default = null)
    {
        $attribute = $this->get($key, $default);

        return $attribute->string();
    }

    /**
     * Get an attribute's value evaluated as a boolean.
     *
     * @param      $key
     * @param null $default
     * @return mixed
     */
    public function getBool($key, $default = null)
    {
        $attribute = $this->get($key, $default);

        return $attribute->bool();
    }

    /**
     * Get an attribute's value as a URL.
     *
     * @param      $key
     * @param null $default
     * @return string
     */
    public function getUrl($key, $default = null)
    {
        $attribute = $this->get($key, $default);

        return $attribute->url();
    }

    /**
     * Get an attribute's value parsed as an array.
     *
     * @param      $key
     * @param null $default
     * @return array
     */
    public function getArray($key, $default = null)
    {
        $attribute = $this->get($key, $default);

        return $attribute->toArray();
    }

    /**
     * Get all attribute values.
     *
     * @return array
     */
    public function allValues()
    {
        return array_map(
            function (Attribute $attribute) {
                return $attribute->getValue();
            },
            parent::all()
        );
    }
}
