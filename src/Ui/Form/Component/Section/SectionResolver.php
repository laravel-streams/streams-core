<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Section;

use Anomaly\Streams\Platform\Support\Resolver;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class SectionResolver
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Section
 */
class SectionResolver
{

    /**
     * The resolver utility.
     *
     * @var Resolver
     */
    protected $resolver;

    /**
     * Create a new SectionResolver instance.
     *
     * @param Resolver $resolver
     */
    public function __construct(Resolver $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * Resolve the form sections.
     *
     * @param FormBuilder $builder
     */
    public function resolve(FormBuilder $builder)
    {
        $this->resolver->resolve($builder->getSections(), compact('builder'));
    }
}
