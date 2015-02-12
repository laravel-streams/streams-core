<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Field;

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
     * @var FieldResolver
     */
    protected $resolver;

    /**
     * The evaluator utility.
     *
     * @var FieldEvaluator
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
     * @param FieldResolver   $resolver
     * @param FieldEvaluator  $evaluator
     * @param FieldNormalizer $normalizer
     * @param FieldGuesser    $guesser
     */
    function __construct(
        FieldResolver $resolver,
        FieldEvaluator $evaluator,
        FieldNormalizer $normalizer,
        FieldGuesser $guesser
    ) {
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
        $this->resolver->resolve($builder);

        $this->normalizer->normalize($builder);
        $this->evaluator->evaluate($builder);

        $this->guesser->guess($builder);
        $this->normalizer->normalize($builder); //Yes, again.
    }
}
