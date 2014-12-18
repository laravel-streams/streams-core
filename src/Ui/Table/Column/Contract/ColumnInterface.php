<?php namespace Anomaly\Streams\Platform\Ui\Table\Column\Contract;

/**
 * Interface ColumnInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Column\Contract
 */
interface ColumnInterface
{

    /**
     * Return the view data.
     *
     * @param array $arguments
     * @return mixed
     */
    public function getTableData();

    /**
     * Set the header.
     *
     * @param $header
     * @return mixed
     */
    public function setHeader($header);

    /**
     * Get the header.
     *
     * @return mixed
     */
    public function getHeader();

    /**
     * Set the prefix.
     *
     * @param $prefix
     * @return mixed
     */
    public function setPrefix($prefix);

    /**
     * Get the prefix.
     *
     * @return mixed
     */
    public function getPrefix();

    /**
     * Set the class.
     *
     * @param $class
     * @return mixed
     */
    public function setClass($class);

    /**
     * Get the class.
     *
     * @return mixed
     */
    public function getClass();

    /**
     * Set the entry object.
     *
     * @param $entry
     * @return mixed
     */
    public function setEntry($entry);

    /**
     * Get the entry.
     *
     * @return mixed
     */
    public function getEntry();

    /**
     * Set the value.
     *
     * @param $value
     * @return mixed
     */
    public function setValue($value);

    /**
     * Get the value.
     *
     * @return mixed
     */
    public function getValue();
}
