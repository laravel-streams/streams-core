<?php namespace Anomaly\Streams\Platform\Ui\Tree\Command;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Ui\Tree\TreeBuilder;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class SetTreeStream
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Tree\Command
 */
class SetTreeStream implements SelfHandling
{

    /**
     * The tree builder.
     *
     * @var TreeBuilder
     */
    protected $builder;

    /**
     * Create a new BuildTreeColumnsCommand instance.
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
         * If the model is not set then they need
         * to load the tree entries themselves.
         */
        if (!class_exists($model)) {
            return;
        }

        /*
         * Resolve the model
         * from the container.
         */
        $model = app($model);

        /**
         * If the model happens to be an instance of
         * EntryInterface then set the stream on the tree.
         */
        if ($model instanceof EntryInterface) {
            $tree->setStream($model->getStream());
        }
    }
}
