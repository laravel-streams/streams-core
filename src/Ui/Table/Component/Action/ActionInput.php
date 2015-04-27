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
     * The resolver utility.
     *
     * @var ActionResolver
     */
    protected $resolver;

    /**
     * The action defaults.
     *
     * @var ActionDefaults
     */
    protected $defaults;

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
     * @param ActionResolver   $resolver
     * @param ActionDefaults   $defaults
     * @param ActionPredictor  $predictor
     * @param ActionEvaluator  $evaluator
     * @param ActionNormalizer $normalizer
     */
    public function __construct(
        ActionResolver $resolver,
        ActionDefaults $defaults,
        ActionPredictor $predictor,
        ActionEvaluator $evaluator,
        ActionNormalizer $normalizer
    ) {
        $this->resolver   = $resolver;
        $this->defaults   = $defaults;
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
        $this->defaults->defaults($builder);
        $this->predictor->predict($builder);
        $this->normalizer->normalize($builder);
    }
}
