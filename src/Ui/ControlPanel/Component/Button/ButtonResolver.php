<?php

namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Button;

use Anomaly\Streams\Platform\Support\Resolver;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;

/**
 * Class ButtonResolver.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\View
 */
class ButtonResolver
{
    /**
     * The resolver utility.
     *
     * @var Resolver
     */
    protected $resolver;

    /**
     * Create a new ButtonResolver instance.
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
     * @param ControlPanelBuilder $builder
     */
    public function resolve(ControlPanelBuilder $builder)
    {
        $this->resolver->resolve($builder->getButtons(), compact('builder'));
    }
}
