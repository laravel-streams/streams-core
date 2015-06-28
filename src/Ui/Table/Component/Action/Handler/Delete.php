<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler;

use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\ActionHandler;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class DeleteActionHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler
 */
class Delete extends ActionHandler
{

    /**
     * Save the order of the entries.
     *
     * @param TableBuilder $builder
     * @param array        $selected
     */
    public function handle(TableBuilder $builder, array $selected)
    {
        $count = 0;

        $model = $builder->getTableModel();

        /* @var EloquentModel $entry */
        foreach ($selected as $id) {
            if ($entry = $model->find($id)) {
                if ($entry->isDeletable() && $entry->delete()) {

                    $builder->fire('row_deleted', compact('builder', 'model', 'entry'));

                    $count++;
                }
            }
        }

        if ($selected) {
            $builder->fire('rows_deleted', compact('count', 'builder', 'model'));
        }

        $this->messages->success(trans('streams::message.delete_success', compact('count')));
    }
}
