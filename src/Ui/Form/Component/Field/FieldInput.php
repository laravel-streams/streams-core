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
     * The field guesser.
     *
     * @var FieldGuesser
     */
    protected $guesser;

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
     * The field populator.
     *
     * @var FieldPopulator
     */
    protected $populator;

    /**
     * The field normalizer.
     *
     * @var FieldNormalizer
     */
    protected $normalizer;

    /**
     * The field translator.
     *
     * @var FieldTranslator
     */
    protected $translator;

    /**
     * Create a new FieldInput instance.
     *
     * @param FieldGuesser    $guesser
     * @param FieldResolver   $resolver
     * @param FieldEvaluator  $evaluator
     * @param FieldPopulator  $populator
     * @param FieldNormalizer $normalizer
     * @param FieldTranslator $translator
     */
    function __construct(
        FieldGuesser $guesser,
        FieldResolver $resolver,
        FieldEvaluator $evaluator,
        FieldPopulator $populator,
        FieldNormalizer $normalizer,
        FieldTranslator $translator
    ) {
        $this->guesser    = $guesser;
        $this->resolver   = $resolver;
        $this->evaluator  = $evaluator;
        $this->populator  = $populator;
        $this->normalizer = $normalizer;
        $this->translator = $translator;
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

        $this->translator->translate($builder);
        $this->populator->populate($builder);
    }
}
