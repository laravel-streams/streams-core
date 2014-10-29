<?php namespace Anomaly\Streams\Platform\Ui\Table;

use Anomaly\Streams\Platform\Ui\Table\Contract\TableViewInterface;

/**
 * Class TableView
 *
 * This is the default table view class that
 * can be extended or used for reference as long
 * as the TableViewInterface is implemented.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table
 */
class TableView implements TableViewInterface
{

    /**
     * Handle the view query.
     *
     * @param $query
     * @return mixed
     */
    public function handle($query)
    {
        return $query;
    }

}
 