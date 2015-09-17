<?php

namespace Anomaly\Streams\Platform\Ui\Tree\Component\Item\Command;

use Anomaly\Streams\Platform\Ui\Tree\Component\Item\ItemBuilder;
use Anomaly\Streams\Platform\Ui\Tree\TreeBuilder;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class BuildItems.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Tree\Component\Item\Command
 */
class BuildItems implements SelfHandling
{
    /**
     * The tree builder.
     *
     * @var TreeBuilder
     */
    protected $builder;

    /**
     * Create a new BuildItems instance.
     *
     * @param TreeBuilder $builder
     */
    public function __construct(TreeBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Handle the command.
     *
     * @param ItemBuilder $builder
     */
    public function handle(ItemBuilder $builder)
    {
        $builder->build($this->builder);
    }
}
