<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Section;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class SectionInput
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Section
 */
class SectionInput
{

    /**
     * The resolver utility.
     *
     * @var SectionResolver
     */
    protected $resolver;

    /**
     * The section evaluator.
     *
     * @var SectionEvaluator
     */
    protected $evaluator;

    /**
     * The section normalizer.
     * 
     * @var SectionNormalizer
     */
    protected $normalizer;

    /**
     * Create a new SectionInput instance.
     *
     * @param SectionResolver   $resolver
     * @param SectionEvaluator  $evaluator
     * @param SectionNormalizer $normalizer
     */
    function __construct(SectionResolver $resolver, SectionEvaluator $evaluator, SectionNormalizer $normalizer)
    {
        $this->resolver  = $resolver;
        $this->evaluator = $evaluator;
        $this->normalizer = $normalizer;
    }

    /**
     * Read the form section input.
     *
     * @param FormBuilder $builder
     */
    public function read(FormBuilder $builder)
    {
        $this->resolver->resolve($builder);
        $this->evaluator->evaluate($builder);
        $this->normalizer->normalize($builder);
    }
}
