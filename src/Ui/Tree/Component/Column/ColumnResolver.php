<?php namespace Anomaly\Streams\Platform\Ui\Tree\Component\Column;

use Anomaly\Streams\Platform\Support\Resolver;
use Anomaly\Streams\Platform\Ui\Tree\TreeBuilder;

/**
 * Class ColumnResolver
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Tree\Component\View
 */
class ColumnResolver
{

    /**
     * The resolver utility.
     *
     * @var Resolver
     */
    protected $resolver;

    /**
     * Create a new ColumnResolver instance.
     *
     * @param Resolver $resolver
     */
    public function __construct(Resolver $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * Resolve tree views.
     *
     * @param TreeBuilder $builder
     */
    public function resolve(TreeBuilder $builder)
    {
        $this->resolver->resolve($builder->getColumns(), compact('builder'));
    }
}
