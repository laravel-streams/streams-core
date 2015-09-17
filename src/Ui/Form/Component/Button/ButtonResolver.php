<?php

namespace Anomaly\Streams\Platform\Ui\Form\Component\Button;

use Anomaly\Streams\Platform\Support\Resolver;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class ButtonResolver.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\View
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
     * Resolve form buttons.
     *
     * @param FormBuilder $builder
     */
    public function resolve(FormBuilder $builder)
    {
        $this->resolver->resolve($builder->getButtons(), compact('builder'));
    }
}
