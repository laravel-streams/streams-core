<?php namespace Anomaly\Streams\Platform\Ui\Table\Column;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\Table\Column\Contract\ColumnInterface;

/**
 * Class Column
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Column
 */
class Column implements ColumnInterface
{
    /**
     * The entry object.
     *
     * @var null
     */
    protected $entry = null;

    /**
     * The column value.
     *
     * @var
     */
    protected $value;

    /**
     * The column class.
     *
     * @var null
     */
    protected $class;

    /**
     * The column prefix.
     *
     * @var null
     */
    protected $prefix;

    /**
     * The column header.
     *
     * @var null
     */
    protected $header;

    /**
     * The column stream.
     *
     * @var \Anomaly\Streams\Platform\Stream\Contract\StreamInterface
     */
    protected $stream;

    /**
     * Create a new Column instance.
     *
     * @param                 $value
     * @param null            $class
     * @param null            $prefix
     * @param null            $header
     * @param StreamInterface $stream
     */
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

    /**
     * Return the view data.
     *
     * @param array $arguments
     * @return array
     */
    public function viewData(array $arguments = [])
    {
        $value = $this->getValue();
        $class = $this->getClass();

        if ($this->getStream() && is_string($value)) {
            $value = $this->getValueFromField($value);
        }

        return compact('value', 'class');
    }

    /**
     * Get the value from a field.
     *
     * @param $value
     * @return mixed
     */
    protected function getValueFromField($value)
    {
        if ($this->entry instanceof EntryInterface) {
            return $this->entry->getFieldValue($value);
        }

        return $value;
    }

    /**
     * Set the class.
     *
     * @param $class
     * @return $this
     */
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * Get the class.
     *
     * @return null
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Set the entry.
     *
     * @param $entry
     * @return $this
     */
    public function setEntry($entry)
    {
        $this->entry = $entry;

        return $this;
    }

    /**
     * Get the entry.
     *
     * @return null
     */
    public function getEntry()
    {
        return $this->entry;
    }

    /**
     * Set the header.
     *
     * @param $header
     * @return $this
     */
    public function setHeader($header)
    {
        $this->header = $header;

        return $this;
    }

    /**
     * Get the header.
     *
     * @return null
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * Set the prefix.
     *
     * @param $prefix
     * @return $this
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Get the prefix.
     *
     * @return null
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Set the stream object.
     *
     * @param $stream
     * @return $this
     */
    public function setStream($stream)
    {
        $this->stream = $stream;

        return $this;
    }

    /**
     * Get the stream object.
     *
     * @return StreamInterface
     */
    public function getStream()
    {
        return $this->stream;
    }

    /**
     * Set the value.
     *
     * @param $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get the value.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}
