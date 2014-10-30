<?php namespace Anomaly\Streams\Platform\Ui\Table\View;

use Anomaly\Streams\Platform\Ui\Table\Contract\TableViewInterface;

/**
 * Class ViewAllTableView
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\View
 */
class ViewAllTableView implements TableViewInterface
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
 