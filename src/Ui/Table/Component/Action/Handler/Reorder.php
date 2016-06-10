<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler;

use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\ActionHandler;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Http\Request;

/**
 * Class ReorderActionHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler
 */
class Reorder extends ActionHandler implements SelfHandling
{

    /**
     * Save the order of the entries.
     *
     * @param TableBuilder $builder
     * @param Request      $request
     */
    public function handle(TableBuilder $builder, Request $request)
    {
        $count = 0;

        $model = $builder->getTableModel();

        /* @var EloquentModel $entry */
        foreach ($request->get($builder->getTableOption('prefix') . 'order', []) as $k => $id) {

            /**
             * If this is a many to many relationship (multiple) then use the entry_id and related_id
             * rather than the id
             */
            if (strstr($id, ':')) {
                $idParts = explode(':', $id);
                if($model->where('entry_id', $idParts[0])->where('related_id', $idParts[1])->update(['sort_order' => $k + 1])) {
                    $count++;
                }
            }

            /**
             * Otherwise just use the id
             */
            if (is_numeric($id) && $entry = $model->find($id)) {
                if (($entry->sort_order = $k + 1) && $entry->save()) {
                    $count++;
                }
            }
        }

        $builder->fire('reordered', compact('count', 'builder'));

        $this->messages->success(trans('streams::message.reorder_success', compact('count')));
    }
}
