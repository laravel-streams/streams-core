<?php namespace Anomaly\Streams\Platform\Ui\Tree\Command;

use Anomaly\Streams\Platform\Ui\Tree\Component\Item\Command\BuildItems;
use Anomaly\Streams\Platform\Ui\Tree\TreeBuilder;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class BuildTree
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class BuildTree
{
    use DispatchesJobs;

    /**
     * The tree builder.
     *
     * @var TreeBuilder
     */
    protected $builder;

    /**
     * Create a new BuildTree instance.
     *
     * @param TreeBuilder $builder
     */
    public function __construct(TreeBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        /*
         * Resolve and set the tree model and stream.
         */
        dispatch_sync(new SetTreeModel($this->builder));
        dispatch_sync(new SetTreeStream($this->builder));
        dispatch_sync(new SetTreeOptions($this->builder));
        dispatch_sync(new SetDefaultOptions($this->builder));
        dispatch_sync(new SetTreeRepository($this->builder));
        dispatch_sync(new SetDefaultParameters($this->builder));

        /*
         * Before we go any further, authorize the request.
         */
        dispatch_sync(new AuthorizeTree($this->builder));

        /*
         * Get tree entries.
         */
        dispatch_sync(new GetTreeEntries($this->builder));

        /*
         * Lastly tree items.
         */
        dispatch_sync(new BuildItems($this->builder));
    }
}
