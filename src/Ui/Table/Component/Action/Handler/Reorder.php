<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler;

use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\ActionHandler;
use Anomaly\Streams\Platform\Ui\Table\Contract\TableModelInterface;
use Anomaly\Streams\Platform\Ui\Table\Table;

/**
 * Class ReorderActionHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler
 */
class Reorder extends ActionHandler
{

    /**
     * Save the order of the entries.
     *
     * @param Table $table
     */
    public function handle(Table $table, array $selected)
    {
        $count = 0;

        $model = $table->getModel();

        /* @var EloquentModel $entry */
        foreach ($selected as $k => $id) {
            if ($entry = $model->find($id)) {
                if ($entry->sort_order = $k && $entry->save()) {
                    $count++;
                }
            }
        }

        $type = $count ? 'success' : 'error';

        $this->messages->{$type}(trans('streams::message.reorder_success', compact('count')));
    }
}
