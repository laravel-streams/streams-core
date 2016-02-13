<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter\Contract;

/**
 * Interface SearchFilterInterface
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Component\Filter\Contract
 */
interface SearchFilterInterface extends FilterInterface
{

    /**
     * Get the columns.
     *
     * @return array
     */
    public function getColumns();

    /**
     * Set the columns.
     *
     * @param array $columns
     * @return $this
     */
    public function setColumns(array $columns);
}
