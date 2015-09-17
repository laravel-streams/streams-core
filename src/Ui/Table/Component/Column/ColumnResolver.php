<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Column;

use Anomaly\Streams\Platform\Support\Resolver;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class ColumnResolver.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\View
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
     * Resolve table views.
     *
     * @param TableBuilder $builder
     */
    public function resolve(TableBuilder $builder)
    {
        $this->resolver->resolve($builder->getColumns(), compact('builder'));
    }
}
