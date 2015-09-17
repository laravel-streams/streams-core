<?php

namespace Anomaly\Streams\Platform\Ui\Tree\Command;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Ui\Tree\TreeBuilder;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class SetTreeStream.
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

        if (is_string($model) && ! class_exists($model)) {
            return;
        }

        if (is_string($model)) {
            $model = app($model);
        }

        if ($model instanceof EntryInterface) {
            $tree->setStream($model->getStream());
        }
    }
}
