<?php namespace Anomaly\Streams\Platform\Ui\Tree\Component\Column\Command;

use Anomaly\Streams\Platform\Ui\Tree\TreeBuilder;

/**
 * Class BuildColumns
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Tree\Component\Column\Command
 */
class BuildColumns
{

    /**
     * The tree builder.
     *
     * @var TreeBuilder
     */
    protected $builder;

    /**
     * Create a new BuildColumns instance.
     *
     * @param TreeBuilder $builder
     */
    public function __construct(TreeBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Get the tree builder.
     *
     * @return TreeBuilder
     */
    public function getBuilder()
    {
        return $this->builder;
    }
}
