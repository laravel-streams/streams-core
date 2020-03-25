<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class SetTableModel
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class SetTableModel
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

        /*
         * If the model is already instantiated
         * then use it as is.
         */
        if (is_object($model)) {
            $table->setModel($model);

            return;
        }

        /*
         * If no model is set, try guessing the
         * model based on best practices.
         */
        if ($model === null) {
            $parts = explode('\\', str_replace('TableBuilder', 'Model', get_class($builder)));

            unset($parts[count($parts) - 2]);

            $model = implode('\\', $parts);

            $builder->setModel($model);
        }

        /*
         * If the model does not exist or
         * is disabled then skip it.
         */
        if (!$model || !class_exists($model)) {
            return;
        }

        /*
         * Set the model on the table!
         */
        $table->setModel(app($model));
    }
}
