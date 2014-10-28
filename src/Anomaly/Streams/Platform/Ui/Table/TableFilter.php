<?php namespace Anomaly\Streams\Platform\Ui\Table;

use Anomaly\Streams\Platform\Ui\Table\Contract\TableFilterInterface;

/**
 * Class TableFilter
 *
 * This is the default table filter class that
 * can be extended or used for reference as long
 * as the TableFilterInterface is implemented.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table
 */
class TableFilter implements TableFilterInterface
{

    /**
     * Handle the filter query.
     *
     * @param $query
     * @param $value
     * @return mixed
     */
    public function handle($query, $value)
    {
        //
    }

}
 