<?php namespace Anomaly\Streams\Platform\Ui\Grid\Command;

use Anomaly\Streams\Platform\Ui\Grid\Component\Item\Command\BuildItems;
use Anomaly\Streams\Platform\Ui\Grid\GridBuilder;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class BuildGrid
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class BuildGrid
{
    use DispatchesJobs;

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
        dispatch_sync(new SetGridModel($this->builder));
        dispatch_sync(new SetGridStream($this->builder));
        dispatch_sync(new SetGridOptions($this->builder));
        dispatch_sync(new SetDefaultOptions($this->builder));
        dispatch_sync(new SetGridRepository($this->builder));
        dispatch_sync(new SetDefaultParameters($this->builder));

        /*
         * Before we go any further, authorize the request.
         */
        dispatch_sync(new AuthorizeGrid($this->builder));

        /*
         * Get grid entries.
         */
        dispatch_sync(new GetGridEntries($this->builder));

        /*
         * Lastly grid items.
         */
        dispatch_sync(new BuildItems($this->builder));
    }
}
