<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Field;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Illuminate\Contracts\Container\Container;

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
     * The services container.
     *
     * @var Container
     */
    protected $container;

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
        Container $container
    ) {
        $this->guesser    = $guesser;
        $this->resolver   = $resolver;
        $this->evaluator  = $evaluator;
        $this->populator  = $populator;
        $this->normalizer = $normalizer;
        $this->container  = $container;
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

        if (env('INSTALLED')) {
            $this->container->make('Anomaly\Streams\Platform\Ui\Form\Component\Field\FieldTranslator')->translate(
                $builder
            );
        }

        $this->populator->populate($builder);
    }
}
