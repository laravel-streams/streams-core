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
     * @param FormBuilder $builder
     */
    public function read(FormBuilder $builder)
    {
        $this->resolveInput($builder);
        $this->normalizeInput($builder);
        $this->evaluateInput($builder);

        $this->guessFields($builder);
        $this->normalizeInput($builder); // Again!
    }

    /**
     * Resolve the field input.
     *
     * @param FormBuilder $builder
     */
    protected function resolveInput(FormBuilder $builder)
    {
        $builder->setFields($this->resolver->resolve($builder->getFields()));
    }

    /**
     * Guess * fields replacer.
     *
     * @param FormBuilder $builder
     */
    protected function guessFields(FormBuilder $builder)
    {
        $this->guesser->guess($builder);
    }

    /**
     * Normalize the field input.
     *
     * @param FormBuilder $builder
     */
    protected function normalizeInput(FormBuilder $builder)
    {
        $builder->setFields($this->normalizer->normalize($builder->getFields()));
    }

    /**
     * Evaluate field input.
     *
     * @param FormBuilder $builder
     */
    protected function evaluateInput(FormBuilder $builder)
    {
        $builder->setFields($this->evaluator->evaluate($builder->getFields()));
    }
}
