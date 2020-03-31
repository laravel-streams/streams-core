<?php

namespace Anomaly\Streams\Platform\Ui\Tree\Command;

use Anomaly\Streams\Platform\Support\Facades\Evaluator;
use Anomaly\Streams\Platform\Support\Facades\Resolver;
use Anomaly\Streams\Platform\Ui\Tree\TreeBuilder;

/**
 * Class SetTreeOptions
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SetTreeOptions
{

    /**
     * The tree builder.
     *
     * @var TreeBuilder
     */
    protected $builder;

    /**
     * Create a new SetTreeOptions instance.
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
        $arguments = ['builder' => $this->builder];

        $tree = $this->builder->getTree();

        $options = $this->builder->getOptions();

        $options = Resolver::resolve($options, $arguments);
        $options = Evaluator::evaluate($options, $arguments);

        foreach ($options as $key => $value) {
            $tree->setOption($key, $value);
        }
    }
}
