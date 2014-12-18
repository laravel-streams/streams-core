<?php namespace Anomaly\Streams\Platform\Ui\Table\View;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;use Anomaly\Streams\Platform\Ui\Table\View\Contract\ViewInterface;

/**
 * Class ViewData
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\View
 */
class ViewData
{

    /**
     * Make the view data.
     *
     * @param TableBuilder $builder
     */
    public function make(TableBuilder $builder)
    {
        $table = $builder->getTable();
        $data  = $table->getData();

        $views = array_map(
            function (ViewInterface $view) {
                return $view->getTableData();
            },
            $table->getViews()->all()
        );

        $data->put('views', $views);
    }
}
