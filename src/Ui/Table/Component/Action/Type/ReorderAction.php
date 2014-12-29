<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Action\Type;

use Anomaly\Streams\Platform\Ui\Table\Component\Action\Action;
use Anomaly\Streams\Platform\Ui\Table\Contract\TableModelInterface;
use Anomaly\Streams\Platform\Ui\Table\Event\TablePostEvent;

/**
 * Class ReorderAction
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Action\Type
 */
class ReorderAction extends Action
{

    /**
     * Handle the TablePostEvent.
     *
     * @param TablePostEvent $event
     */
    protected function handleTablePostEvent(TablePostEvent $event)
    {
        $table = $event->getTable();
        $model = $table->getModel();

        if ($model instanceof TableModelInterface) {
            $model->sortTableEntries($table);
        }
    }
}
