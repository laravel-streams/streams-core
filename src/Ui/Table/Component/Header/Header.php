<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Header;

/*
 * Class Header
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Header
 */

use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;
use Anomaly\Streams\Platform\Traits\HasAttributes;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Support\Facades\Hydrator;
use Anomaly\Streams\Platform\Ui\Traits\HasClassAttribute;
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
    use HasClassAttribute;

    /**
     * The object attributes.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * The header field.
     *
     * @var string
     */
    protected $field;

    /**
     * The table builder.
     *
     * @var TableBuilder
     */
    protected $builder;

    /**
     * The header heading.
     *
     * @var string
     */
    protected $heading;

    /**
     * The sort column.
     *
     * @var string
     */
    protected $sortColumn;

    /**
     * The sortable flag.
     *
     * @var bool
     */
    protected $sortable = false;

    /**
     * Get the query string with
     * this column being sorted.
     *
     * @return string
     */
    public function getQueryString()
    {
        $query = $_GET;

        $builder   = $this->getBuilder();
        $direction = $this->getDirection('asc');

        array_set($query, $builder->getTableOption('prefix') . 'order_by', $this->getSortColumn());
        array_set($query, $builder->getTableOption('prefix') . 'sort', $direction == 'asc' ? 'desc' : 'asc');

        return http_build_query($query);
    }

    /**
     * Get the field.
     *
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Set the field.
     *
     * @param  $field
     * @return $this
     */
    public function setField($field)
    {
        $this->field = $field;

        return $this;
    }

    /**
     * Get the table builder.
     *
     * @return TableBuilder
     */
    public function getBuilder()
    {
        return $this->builder;
    }

    /**
     * Set the table builder.
     *
     * @param  TableBuilder $builder
     * @return $this
     */
    public function setBuilder(TableBuilder $builder)
    {
        $this->builder = $builder;

        return $this;
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

        $builder = $this->getBuilder();

        if (array_get($query, $builder->getTableOption('prefix') . 'order_by') !== $this->getSortColumn()) {
            return null;
        }

        return array_get($query, $builder->getTableOption('prefix') . 'sort', $default);
    }

    /**
     * Get the sort column.
     *
     * @return string
     */
    public function getSortColumn()
    {
        return $this->sortColumn;
    }

    /**
     * Set the sort column.
     *
     * @param  string $sortColumn
     * @return $this
     */
    public function setSortColumn($sortColumn)
    {
        $this->sortColumn = $sortColumn;

        return $this;
    }

    /**
     * Get the header heading.
     *
     * @return mixed
     */
    public function getHeading()
    {
        return $this->heading;
    }

    /**
     * Set the header heading.
     *
     * @param $heading
     * @return $this
     */
    public function setHeading($heading)
    {
        $this->heading = $heading;

        return $this;
    }

    /**
     * Get the sortable flag.
     *
     * @return boolean
     */
    public function isSortable()
    {
        return $this->sortable;
    }

    /**
     * Set the sortable flag.
     *
     * @param  boolean $sortable
     * @return $this
     */
    public function setSortable($sortable)
    {
        $this->sortable = $sortable;

        return $this;
    }

    /**
     * Return merged attributes.
     *
     * @param array $attributes
     * @return array
     */
    public function attributes(array $attributes = [])
    {
        return array_filter(array_merge($this->attributes, [
            'class' => $this->class(),
        ], $attributes));
    }

    /**
     * Return class HTML.
     *
     * @param string $class
     * @return null|string
     */
    public function class($class = null)
    {
        if ($direction = $this->getDirection()) {
            $class .= '--sorting --' . $direction;
        }

        return trim(implode(' ', [
            $class,
            $this->getClass()
        ]));
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
}
