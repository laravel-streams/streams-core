<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Header;

use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;
use Anomaly\Streams\Platform\Traits\HasAttributes;
use Anomaly\Streams\Platform\Support\Facades\Hydrator;
use Anomaly\Streams\Platform\Ui\Table\Component\Header\Contract\HeaderInterface;

/**
 * Class Header
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Header implements HeaderInterface, Arrayable, Jsonable
{

    use HasAttributes;

    /**
     * The object attributes.
     *
     * @var array
     */
    protected $attributes = [
        'field' => null,
        'builder' => null,
        'heading' => null,
        'sort_column' => null,
        'sortable' => false,
    ];

    /**
     * Get the query string with
     * this column being sorted.
     *
     * @return string
     */
    public function getQueryString()
    {
        $query = $_GET;

        $builder   = $this->builder;
        $direction = $this->getDirection('asc');

        array_set($query, $builder->getTableOption('prefix') . 'order_by', $this->sort_column);
        array_set($query, $builder->getTableOption('prefix') . 'sort', $direction == 'asc' ? 'desc' : 'asc');

        return http_build_query($query);
    }

    /**
     * Get the current direction
     * defaulting to ascending.
     *
     * @param  null        $default
     * @return string|null
     */
    public function getDirection($default = null)
    {
        $query = $_GET;

        $builder = $this->builder;

        if (array_get($query, $builder->getTableOption('prefix') . 'order_by') !== $this->sort_column) {
            return null;
        }

        return array_get($query, $builder->getTableOption('prefix') . 'sort', $default);
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
