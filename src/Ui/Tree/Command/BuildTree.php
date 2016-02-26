<?php namespace Anomaly\Streams\Platform\Ui\Tree\Command;

use Anomaly\Streams\Platform\Ui\Tree\Component\Item\Command\BuildItems;
use Anomaly\Streams\Platform\Ui\Tree\TreeBuilder;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class BuildTree
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Tree\Command
 */
class BuildTree implements SelfHandling
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
        /**
         * Resolve and set the tree model and stream.
         */
        $this->dispatch(new SetTreeModel($this->builder));
        $this->dispatch(new SetTreeStream($this->builder));
        $this->dispatch(new SetTreeOptions($this->builder));
        $this->dispatch(new SetDefaultOptions($this->builder));
        $this->dispatch(new SetTreeRepository($this->builder));
        $this->dispatch(new SetDefaultParameters($this->builder));

        /**
         * Before we go any further, authorize the request.
         */
        $this->dispatch(new AuthorizeTree($this->builder));

        /**
         * Get tree entries.
         */
        $this->dispatch(new GetTreeEntries($this->builder));

        /**
         * Lastly tree items.
         */
        $this->dispatch(new BuildItems($this->builder));
    }
}
