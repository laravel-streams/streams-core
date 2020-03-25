<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class SetTableStream
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class SetTableStream
{

    /**
     * Handle the command.
     * 
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {
        $table = $builder->getTable();
        $model = $builder->getModel();

        if (is_string($model) && !class_exists($model)) {
            return;
        }

        if (is_string($model)) {
            $model = app($model);
        }

        if ($model instanceof EntryInterface) {
            $table->setStream($model->stream());
        }
    }
}
