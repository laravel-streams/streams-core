<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Column;

use Anomaly\Streams\Platform\Ui\Table\Component\Column\Contract\ColumnInterface;

/**
 * Class Column
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Column
 */
class Column implements ColumnInterface
{

    /**
     * The column value.
     *
     * @var null|mixed
     */
    protected $value = null;

    /**
     * The column class.
     *
     * @var null|string
     */
    protected $class = null;

    /**
     * The column header.
     *
     * @var null|string
     */
    protected $header = null;

    /**
     * Set the column class.
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
     * Get the column class.
     *
     * @return null|string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Set the column header.
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
     * Get the column header.
     *
     * @return null|string
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * Set the column value.
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
     * Get the column value.
     *
     * @return mixed|null
     */
    public function getValue()
    {
        return $this->value;
    }
}
