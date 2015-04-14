<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Action\Predict;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class SortablePredictor
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Action\Predict
 */
class SortablePredictor
{

    /**
     * Predict the presence of of the sortable action.
     *
     * @param TableBuilder $builder
     */
    public function predict(TableBuilder $builder)
    {
        if ($builder->getTableOption('sortable')) {
            $builder->setActions(array_merge(['reorder'], $builder->getActions()));
        }
    }
}
