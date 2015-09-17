<?php

namespace Anomaly\Streams\Platform\Ui\Grid\Command;

use Anomaly\Streams\Platform\Ui\Grid\GridBuilder;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class SetGridRepository.
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Grid\Command
 */
class SetGridRepository implements SelfHandling
{
    /**
     * The grid builder.
     *
     * @var GridBuilder
     */
    protected $builder;

    /**
     * Create a new SetGridRepository instance.
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
        $model = $grid->getModel();

        $repository = $grid->getOption('repository');

        /*
         * If there is no repository
         * then skip this step.
         */
        if (! $repository) {
            return;
        }

        /*
         * Set the repository on the form!
         */
        $grid->setRepository(app()->make($repository, compact('model', 'grid')));
    }
}
