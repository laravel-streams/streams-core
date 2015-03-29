<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler;

use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\Action;
use Anomaly\Streams\Platform\Ui\Table\Table;

/**
 * Class DeleteActionHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler
 */
class Delete extends Action
{

    /**
     * Save the order of the entries.
     *
     * @param Table $table
     * @param array $selected
     */
    public function handle(Table $table, array $selected)
    {
        $model = $table->getModel();

        /* @var EloquentModel $entry */
        foreach ($selected as $id) {
            if ($entry = $model->find($id)) {
                if ($entry->isDeletable() && $entry->delete()) {
                    // $count++
                }
            }
        }
    }
}
