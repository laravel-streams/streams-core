<?php namespace Anomaly\Streams\Platform\Ui\Table\Contract;

/**
 * Interface TableFilterInterface
 *
 * This interface helps assure that table filter
 * handlers can at least handle the filter request.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Contract
 */
interface TableFilterInterface
{

    /**
     * Handle the filter query.
     *
     * @param $query
     * @param $value
     * @return mixed
     */
    public function handle($query, $value);
}
 