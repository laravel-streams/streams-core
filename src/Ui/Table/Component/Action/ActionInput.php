<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Action;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class ActionInput
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Action
 */
class ActionInput
{

    /**
     * The action parser.
     *
     * @var ActionParser
     */
    private $parser;

    /**
     * The action lookup.
     *
     * @var ActionLookup
     */
    protected $lookup;

    /**
     * The action guesser.
     *
     * @var ActionGuesser
     */
    protected $guesser;

    /**
     * The resolver utility.
     *
     * @var ActionResolver
     */
    protected $resolver;

    /**
     * The action predictor.
     *
     * @var ActionPredictor
     */
    protected $predictor;

    /**
     * The evaluator utility.
     *
     * @var ActionEvaluator
     */
    protected $evaluator;

    /**
     * The action normalizer.
     *
     * @var ActionNormalizer
     */
    protected $normalizer;

    /**
     * Create a new ActionInput instance.
     *
     * @param ActionParser     $parser
     * @param ActionLookup     $lookup
     * @param ActionGuesser    $guesser
     * @param ActionResolver   $resolver
     * @param ActionPredictor  $predictor
     * @param ActionEvaluator  $evaluator
     * @param ActionNormalizer $normalizer
     */
    public function __construct(
        ActionParser $parser,
        ActionLookup $lookup,
        ActionGuesser $guesser,
        ActionResolver $resolver,
        ActionPredictor $predictor,
        ActionEvaluator $evaluator,
        ActionNormalizer $normalizer
    ) {
        $this->parser     = $parser;
        $this->lookup     = $lookup;
        $this->guesser    = $guesser;
        $this->resolver   = $resolver;
        $this->predictor  = $predictor;
        $this->evaluator  = $evaluator;
        $this->normalizer = $normalizer;
    }

    /**
     * Read builder action input.
     *
     * @param TableBuilder $builder
     * @return array
     */
    public function read(TableBuilder $builder)
    {
        $this->resolver->resolve($builder);
        $this->evaluator->evaluate($builder);
        $this->predictor->predict($builder);
        $this->normalizer->normalize($builder);
        $this->lookup->merge($builder);
        $this->guesser->guess($builder);
        $this->parser->parse($builder);
    }
}
