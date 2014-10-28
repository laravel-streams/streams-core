<?php namespace Anomaly\Streams\Platform\Ui\Table\Contract;

/**
 * Interface TableViewInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Contract
 */
interface TableViewInterface
{

    /**
     * Handle the view query.
     *
     * @param $query
     * @return mixed
     */
    public function handle($query);

}
 