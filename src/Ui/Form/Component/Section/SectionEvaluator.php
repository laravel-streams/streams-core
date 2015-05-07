<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Section;

use Anomaly\Streams\Platform\Support\Evaluator;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class SectionEvaluator
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Section
 */
class SectionEvaluator
{

    /**
     * The evaluator utility.
     *
     * @var Evaluator
     */
    protected $evaluator;

    /**
     * Create a new SectionEvaluator instance.
     *
     * @param Evaluator $evaluator
     */
    public function __construct(Evaluator $evaluator)
    {
        $this->evaluator = $evaluator;
    }

    /**
     * Evaluate the form sections.
     *
     * @param FormBuilder $builder
     */
    public function evaluate(FormBuilder $builder)
    {
        $builder->setSections($this->evaluator->evaluate($builder->getSections(), compact('builder')));
    }
}
