<?php namespace Anomaly\Streams\Platform\Ui\Table\Column;

use Anomaly\Streams\Platform\Ui\Table\Column\Contract\ColumnInterface;

class Column implements ColumnInterface
{

    protected $value;

    protected $field;

    protected $class;

    protected $prefix;

    function __construct($value, $field, $class = null, $prefix = null)
    {
        $this->value  = $value;
        $this->field  = $field;
        $this->class  = $class;
        $this->prefix = $prefix;
    }

    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    public function getPrefix()
    {
        return $this->prefix;
    }

    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    public function getClass()
    {
        return $this->class;
    }

    public function setField($field)
    {
        $this->field = $field;

        return $this;
    }

    public function getField()
    {
        return $this->field;
    }

    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    public function getValue()
    {
        return $this->value;
    }
}
 