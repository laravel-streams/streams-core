<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Header;

use Anomaly\Streams\Platform\Support\Evaluator;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class HeaderEvaluator.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Header
 */
class HeaderEvaluator
{
    /**
     * The evaluator utility.
     *
     * @var Evaluator
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
     * Evaluate the table columns.
     *
     * @param TableBuilder $builder
     */
    public function evaluate(TableBuilder $builder)
    {
        $builder->setColumns($this->evaluator->evaluate($builder->getColumns(), compact('builder')));
    }
}
