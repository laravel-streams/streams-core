<?php

namespace Anomaly\Streams\Platform\Ui\Tree\Command;

use Anomaly\Streams\Platform\Ui\Tree\Component\Item\ItemBuilder;
use Anomaly\Streams\Platform\Ui\Tree\TreeBuilder;

/**
 * Class BuildTree
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class BuildTree
{
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
        dispatch_now(new SetTreeModel($this->builder));
        dispatch_now(new SetTreeStream($this->builder));
        dispatch_now(new SetTreeOptions($this->builder));
        dispatch_now(new SetDefaultOptions($this->builder));
        dispatch_now(new SetTreeRepository($this->builder));
        dispatch_now(new SetDefaultParameters($this->builder));

        /*
         * Before we go any further, authorize the request.
         */
        dispatch_now(new AuthorizeTree($this->builder));

        /*
         * Get tree entries.
         */
        dispatch_now(new GetTreeEntries($this->builder));

        /*
         * Lastly tree items.
         */
        ItemBuilder::build($this->builder);
    }
}
