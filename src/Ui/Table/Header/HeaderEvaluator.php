<?php namespace Anomaly\Streams\Platform\Ui\Table\Header;

use Anomaly\Streams\Platform\Support\Evaluator;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class HeaderEvaluator
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Header
 */
class HeaderEvaluator
{

    /**
     * The evaluator.
     *
     * @var \Anomaly\Streams\Platform\Support\Evaluator
     */
    protected $evaluator;

    /**
     * Create a new HeaderEvaluator instance.
     *
     * @param Evaluator $evaluator
     */
    public function __construct(Evaluator $evaluator)
    {
        $this->evaluator = $evaluator;
    }

    /**
     * Process and evaluate parameter values.
     *
     * @param array $parameters
     * @return array
     */
    public function process(array $parameters, TableBuilder $builder)
    {
        return $this->evaluator->evaluate($parameters, compact('builder'));
    }
}
