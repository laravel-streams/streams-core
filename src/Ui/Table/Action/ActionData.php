<?php namespace Anomaly\Streams\Platform\Ui\Table\Action;

use Anomaly\Streams\Platform\Ui\Table\Action\Contract\ActionInterface;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class ActionData
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Action
 */
class ActionData
{

    /**
     * Make the action data.
     *
     * @param TableBuilder $builder
     */
    public function make(TableBuilder $builder)
    {
        $table = $builder->getTable();
        $data  = $table->getData();

        $actions = array_map(
            function (ActionInterface $action) {
                return $action->viewData();
            },
            $table->getActions()->all()
        );

        $data->put('actions', $actions);
    }
}
