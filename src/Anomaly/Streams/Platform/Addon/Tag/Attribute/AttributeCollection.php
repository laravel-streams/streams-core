<?php namespace Anomaly\Streams\Platform\Addon\Tag\Attribute;

use Illuminate\Support\Collection;

class AttributeCollection extends Collection
{
    public function __construct($attributes = array())
    {
        foreach ($attributes as $key => $value) {
            $this->items[$key] = new Attribute($key, $value);
        }
    }

    public function allValues()
    {
        return array_map(
            function (Attribute $attribute) {
                return $attribute->getValue();
            },
            parent::all()
        );
    }

    public function get($key, $default = null)
    {
        $value = parent::get($key, $default);

        if (!$value instanceof Attribute) {

            $value = new Attribute($key, $value);
        }

        return $value;
    }

    public function getValue($key, $default = null)
    {
        $attribute = $this->get($key, $default);

        return $attribute->getValue();
    }

    public function getString($key, $default = null)
    {
        $attribute = $this->get($key, $default);

        return $attribute->string();
    }

    public function getBool($key, $default = null)
    {
        $attribute = $this->get($key, $default);

        return $attribute->bool();
    }

    public function getUrl($key, $default = null)
    {
        $attribute = $this->get($key, $default);

        $url = $attribute->getValue();

        if (!str_contains('http', $url)) {
            $url = url($url);
        }

        return $url;
    }

    public function getArray($key, $default = null)
    {
        $attribute = $this->get($key, $default);

        return $attribute->toArray();
    }
}
