<?php namespace Anomaly\Streams\Platform\Ui\Table\Column;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\Table\Column\Contract\ColumnInterface;

class Column implements ColumnInterface
{
    protected $entry = null;

    protected $value;

    protected $class;

    protected $prefix;

    protected $header;

    protected $stream;

    public function __construct(
        $value,
        $class = null,
        $prefix = null,
        $header = null,
        StreamInterface $stream = null
    ) {
        $this->value  = $value;
        $this->class  = $class;
        $this->prefix = $prefix;
        $this->header = $header;
        $this->stream = $stream;
    }

    public function viewData(array $arguments = [])
    {
        $value = $this->getValue();
        $class = $this->getClass();

        if ($this->getStream() && is_string($value)) {
            $value = $this->getValueFromField($value);
        }

        return evaluate(compact('value', 'class'), $arguments);
    }

    protected function getValueFromField($value)
    {
        if ($this->entry instanceof EntryInterface) {
            return $this->entry->getFieldValue($value);
        }

        return $value;
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

    public function setEntry($entry)
    {
        $this->entry = $entry;

        return $this;
    }

    public function getEntry()
    {
        return $this->entry;
    }

    public function setHeader($header)
    {
        $this->header = $header;

        return $this;
    }

    public function getHeader()
    {
        return $this->header;
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

    public function setStream($stream)
    {
        $this->stream = $stream;

        return $this;
    }

    public function getStream()
    {
        return $this->stream;
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
