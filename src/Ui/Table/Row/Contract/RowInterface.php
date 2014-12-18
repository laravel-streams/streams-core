<?php namespace Anomaly\Streams\Platform\Ui\Table\Row\Contract;

/**
 * Interface RowInterface
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Row\Contract
 */
interface RowInterface
{

    /**
     * Return the view data.
     *
     * @param  array $arguments
     * @return mixed
     */
    public function getTableData();
}
