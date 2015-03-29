<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class SetTableModel
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Command
 */
class SetTableModel implements SelfHandling
{

    /**
     * The table builder.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\TableBuilder
     */
    protected $builder;

    /**
     * Create a new BuildTableColumnsCommand instance.
     *
     * @param TableBuilder $builder
     */
    public function __construct(TableBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        $table = $this->builder->getTable();
        $model = $this->builder->getModel();

        /**
         * If the model is already instantiated
         * then use it as is.
         */
        if (is_object($model)) {

            $table->setModel($model);

            return;
        }

        /**
         * If no model is set, try guessing the
         * model based on best practices.
         */
        if (!$model) {

            $parts = explode('\\', str_replace('TableBuilder', 'Model', get_class($this->builder)));

            unset($parts[count($parts) - 2]);

            $model = implode('\\', $parts);

            $this->builder->setModel($model);
        }

        /**
         * If the model is not set then skip it.
         */
        if (!class_exists($model)) {
            return;
        }

        /**
         * Set the model on the table!
         */
        $table->setModel(app($model));
    }
}
