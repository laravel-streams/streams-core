<?php namespace Anomaly\Streams\Platform\Ui\Table\Column;

use Anomaly\Streams\Platform\Ui\Table\Column\Contract\ColumnInterface;
use Anomaly\Streams\Platform\Ui\Table\Header\Contract\HeaderInterface;

class Column implements ColumnInterface
{

    protected $value;

    protected $class;

    protected $prefix;

    protected $header;

    function __construct($value, $class = null, $prefix = null, HeaderInterface $header = null)
    {
        $this->value  = $value;
        $this->class  = $class;
        $this->prefix = $prefix;
        $this->header = $header;
    }

    public function viewData()
    {
        $value = $this->getValue();

        return compact('value');
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

    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setHeader(HeaderInterface $header)
    {
        $this->header = $header;

        return $this;
    }

    public function getHeader()
    {
        return $this->header;
    }
}
 