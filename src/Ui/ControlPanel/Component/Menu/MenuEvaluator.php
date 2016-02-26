<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Menu;

use Anomaly\Streams\Platform\Support\Evaluator;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;

/**
 * Class MenuEvaluator
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\ControlPanel\Component\Menu
 */
class MenuEvaluator
{

    /**
     * The evaluator utility.
     *
     * @var Evaluator
     */
    protected $evaluator;

    /**
     * Create a new MenuEvaluator instance.
     *
     * @param Evaluator $evaluator
     */
    public function __construct(Evaluator $evaluator)
    {
        $this->evaluator = $evaluator;
    }

    /**
     * Evaluate the control panel menus.
     *
     * @param ControlPanelBuilder $builder
     */
    public function evaluate(ControlPanelBuilder $builder)
    {
        $builder->setMenu($this->evaluator->evaluate($builder->getMenu(), compact('builder')));
    }
}
