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

    public function get($key, $default = null)
    {
        $value = parent::get($key, $default);

        if (!$value instanceof Attribute) {

            $value = new Attribute($key, $value);
        }

        return $value;
    }
}
