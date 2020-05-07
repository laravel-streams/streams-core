<?php

namespace Anomaly\Streams\Platform\Ui\Button;

use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;
use Anomaly\Streams\Platform\Traits\HasAttributes;
use Anomaly\Streams\Platform\Support\Facades\Hydrator;
use Anomaly\Streams\Platform\Ui\Traits\HasClassAttribute;

/**
 * Class Button
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Button implements Arrayable, Jsonable
{

    use HasAttributes;
    use HasClassAttribute;

    /**
     * The button attributes.
     *
     * @var array
     */
    protected $attributes = [
        'tag' => 'a',
        'url' => null,
        'text' => null,
        'entry' => null,
        'policy' => null,
        'enabled' => true,
        'primary' => false,
        'disabled' => false,
        'type' => 'default',
    ];

    /**
     * Return the open tag.
     *
     * @param array $attributes
     * @return string
     */
    public function open(array $attributes = [])
    {
        // @todo extend into the parent when ready
        return '<' . $this->tag . ' ' . html_attributes($this->attributes($attributes)) . '>';
    }

    /**
     * Return the close tag.
     *
     * @return string
     */
    public function close()
    {
        return '</' . $this->tag . '>';
    }

    /**
     * Return merged attributes.
     *
     * @param array $attributes
     */
    public function attributes(array $attributes = [])
    {
        return array_merge($this->attributes, [
            'class' => $this->class,
        ], $attributes);
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return Hydrator::dehydrate($this);
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int  $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    /**
     * Dynamically retrieve attributes.
     *
     * @param  string $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->getAttribute($key);
    }

    /**
     * Dynamically set attributes.
     *
     * @param  string  $key
     * @param  mixed $value
     */
    public function __set($key, $value)
    {
        $this->setAttribute($key, $value);
    }
}
