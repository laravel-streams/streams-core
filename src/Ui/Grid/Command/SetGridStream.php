<?php namespace Anomaly\Streams\Platform\Ui\Grid\Command;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Ui\Grid\GridBuilder;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class SetGridStream
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Grid\Command
 */
class SetGridStream implements SelfHandling
{

    /**
     * The grid builder.
     *
     * @var GridBuilder
     */
    protected $builder;

    /**
     * Create a new BuildGridColumnsCommand instance.
     *
     * @param GridBuilder $builder
     */
    public function __construct(GridBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        $grid  = $this->builder->getGrid();
        $model = $this->builder->getModel();

        if (is_string($model) && !class_exists($model)) {
            return;
        }

        if (is_string($model)) {
            $model = app($model);
        }
        
        if ($model instanceof EntryInterface) {
            $grid->setStream($model->getStream());
        }
    }
}
