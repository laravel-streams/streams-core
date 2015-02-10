<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Field;

use Anomaly\Streams\Platform\Support\Evaluator;
use Anomaly\Streams\Platform\Support\Resolver;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class FieldInput
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Field
 */
class FieldInput
{

    /**
     * The resolver utility.
     *
     * @var \Anomaly\Streams\Platform\Support\Resolver
     */
    protected $resolver;

    /**
     * The evaluator utility.
     *
     * @var Evaluator
     */
    protected $evaluator;

    /**
     * The field normalizer.
     *
     * @var FieldNormalizer
     */
    protected $normalizer;

    /**
     * The field guesser.
     *
     * @var FieldGuesser
     */
    protected $guesser;

    /**
     * Create a new FieldInput instance.
     *
     * @param Resolver        $resolver
     * @param Evaluator       $evaluator
     * @param FieldNormalizer $normalizer
     * @param FieldGuesser    $guesser
     */
    function __construct(Resolver $resolver, Evaluator $evaluator, FieldNormalizer $normalizer, FieldGuesser $guesser)
    {
        $this->guesser    = $guesser;
        $this->resolver   = $resolver;
        $this->evaluator  = $evaluator;
        $this->normalizer = $normalizer;
    }

    /**
     * Read the form input.
     *
     * @param FormBuilder $builder
     */
    public function read(FormBuilder $builder)
    {
        $builder->setFields($this->resolver->resolve($builder->getFields(), compact('builder')));

        $this->normalizer->normalize($builder);
        $builder->setFields($this->evaluator->evaluate($builder->getFields()));

        $this->guesser->guess($builder);
        $this->normalizer->normalize($builder); //Yes, again.
    }
}
