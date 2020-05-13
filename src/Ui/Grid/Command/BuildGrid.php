<?php

namespace Anomaly\Streams\Platform\Ui\Grid\Command;

use Anomaly\Streams\Platform\Ui\Grid\GridBuilder;
use Anomaly\Streams\Platform\Ui\Grid\Component\Item\Command\BuildItems;

/**
 * Class BuildGrid
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class BuildGrid
{

    /**
     * The grid builder.
     *
     * @var GridBuilder
     */
    protected $builder;

    /**
     * Create a new BuildGrid instance.
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
        /*
         * Resolve and set the grid model and stream.
         */
        dispatch_now(new SetGridModel($this->builder));
        dispatch_now(new SetGridStream($this->builder));
        dispatch_now(new SetGridOptions($this->builder));
        dispatch_now(new SetDefaultOptions($this->builder));
        dispatch_now(new SetGridRepository($this->builder));
        dispatch_now(new SetDefaultParameters($this->builder));

        /*
         * Before we go any further, authorize the request.
         */
        dispatch_now(new AuthorizeGrid($this->builder));

        /*
         * Get grid entries.
         */
        dispatch_now(new GetGridEntries($this->builder));

        /*
         * Lastly grid items.
         */
        dispatch_now(new BuildItems($this->builder));
    }
}
