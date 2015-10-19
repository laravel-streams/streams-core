<?php namespace Anomaly\Streams\Platform\Ui\Tree\Command;

use Anomaly\Streams\Platform\Ui\Tree\Contract\TreeRepositoryInterface;
use Anomaly\Streams\Platform\Ui\Tree\TreeBuilder;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class GetTreeEntries
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Tree\Command
 */
class GetTreeEntries implements SelfHandling
{

    /**
     * The tree builder.
     *
     * @var \Anomaly\Streams\Platform\Ui\Tree\TreeBuilder
     */
    protected $builder;

    /**
     * Create a new BuildTreeSegmentsCommand instance.
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
        $tree  = $this->builder->getTree();
        $model = $this->builder->getModel();

        /**
         * If the builder has an entries handler
         * then call it through the container and
         * let it load the entries itself.
         */
        if ($handler = $tree->getOption('entries')) {

            app()->call($handler, ['builder' => $this->builder]);

            return;
        }

        $entries = $tree->getEntries();

        /**
         * If the entries have already been set on the
         * tree then return. Nothing to do here.
         *
         * If the model is not set then they need
         * to load the tree entries themselves.
         */
        if (!$entries->isEmpty() || !$model) {
            return;
        }

        /**
         * Resolve the model out of the container.
         */
        $repository = $tree->getRepository();

        /**
         * If the repository is an instance of
         * TreeRepositoryInterface use it.
         */
        if ($repository instanceof TreeRepositoryInterface) {
            $tree->setEntries($repository->get($this->builder));
        }
    }
}
