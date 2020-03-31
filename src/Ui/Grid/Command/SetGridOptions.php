<?php

namespace Anomaly\Streams\Platform\Ui\Grid\Command;

use Anomaly\Streams\Platform\Support\Facades\Evaluator;
use Anomaly\Streams\Platform\Support\Facades\Resolver;
use Anomaly\Streams\Platform\Ui\Grid\GridBuilder;

/**
 * Class SetGridOptions
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SetGridOptions
{

    /**
     * The grid builder.
     *
     * @var GridBuilder
     */
    protected $builder;

    /**
     * Create a new SetGridOptions instance.
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
        $arguments = ['builder' => $this->builder];

        $grid = $this->builder->getGrid();

        $options = $this->builder->getOptions();

        $options = Resolver::resolve($options, $arguments);
        $options = Evaluator::evaluate($options, $arguments);

        foreach ($options as $key => $value) {
            $grid->setOption($key, $value);
        }
    }
}
