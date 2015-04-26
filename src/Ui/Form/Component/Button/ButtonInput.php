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
     * The button defaults.s
     *
     * @var ButtonDefaults
     */
    protected $defaults;

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
     * @param ButtonGuesser    $guesser
     * @param ButtonResolver   $resolver
     * @param ButtonDefaults   $defaults
     * @param ButtonEvaluator  $evaluator
     * @param ButtonNormalizer $normalizer
     */
    public function __construct(
        ButtonParser $parser,
        ButtonGuesser $guesser,
        ButtonResolver $resolver,
        ButtonDefaults $defaults,
        ButtonEvaluator $evaluator,
        ButtonNormalizer $normalizer
    ) {
        $this->parser     = $parser;
        $this->guesser    = $guesser;
        $this->resolver   = $resolver;
        $this->defaults   = $defaults;
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
        $this->defaults->defaults($builder);
        $this->parser->parse($builder);
        $this->normalizer->normalize($builder);
        $this->guesser->guess($builder);
    }
}
