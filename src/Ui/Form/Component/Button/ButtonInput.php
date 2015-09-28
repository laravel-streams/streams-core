<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Button;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class ButtonInput
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Button
 */
class ButtonInput
{

    /**
     * The button parser.
     *
     * @var ButtonParser
     */
    protected $parser;

    /**
     * The button lookup.
     *
     * @var ButtonLookup
     */
    protected $lookup;

    /**
     * The button guesser.
     *
     * @var ButtonGuesser
     */
    protected $guesser;

    /**
     * The resolver utility.
     *
     * @var ButtonResolver
     */
    protected $resolver;

    /**
     * The button evaluator.
     *
     * @var ButtonEvaluator
     */
    protected $evaluator;

    /**
     * The button normalizer.
     *
     * @var ButtonNormalizer
     */
    protected $normalizer;

    /**
     * Create a new ButtonInput instance.
     *
     * @param ButtonParser     $parser
     * @param ButtonLookup     $lookup
     * @param ButtonGuesser    $guesser
     * @param ButtonResolver   $resolver
     * @param ButtonEvaluator  $evaluator
     * @param ButtonNormalizer $normalizer
     */
    public function __construct(
        ButtonParser $parser,
        ButtonLookup $lookup,
        ButtonGuesser $guesser,
        ButtonResolver $resolver,
        ButtonEvaluator $evaluator,
        ButtonNormalizer $normalizer
    ) {
        $this->parser     = $parser;
        $this->lookup     = $lookup;
        $this->guesser    = $guesser;
        $this->resolver   = $resolver;
        $this->evaluator  = $evaluator;
        $this->normalizer = $normalizer;
    }

    /**
     * Read builder button input.
     *
     * @param FormBuilder $builder
     */
    public function read(FormBuilder $builder)
    {
        $this->resolver->resolve($builder);
        $this->evaluator->evaluate($builder);
        $this->normalizer->normalize($builder);
        $this->lookup->merge($builder);
        $this->parser->parse($builder);
        $this->guesser->guess($builder);
    }
}
