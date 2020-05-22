<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler;

use Anomaly\Streams\Platform\Entry\EntryRepository;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Message\Facades\Messages;

/**
 * Class ForceDeleteActionHandler
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ForceDelete
{

    /**
     * ForceDelete the selected entries.
     *
     * @param TableBuilder $builder
     * @param array        $selected
     */
    public function handle(TableBuilder $builder, array $selected)
    {
        $count = 0;

        $repository = (new EntryRepository)->setModel($builder->actionsTableModel());

        /* @var EloquentModel $entry */
        foreach ($selected as $id) {
            if ($entry = $repository->findTrashed($id)) {
                if ($entry->trashed() && $repository->forceDelete($entry)) {
                    $builder->fire('row_deleted', compact('builder', 'entry'));

                    $count++;
                }
            }
        }

        if ($count) {
            $builder->fire('rows_deleted', compact('count', 'builder'));
        }

        if ($selected) {
            Messages::success(trans('streams::message.delete_success', compact('count')));
        }
    }
}
