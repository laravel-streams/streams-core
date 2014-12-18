<?php namespace Anomaly\Streams\Platform\Ui\Button;

/**
 * Class ButtonBuilder
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Button
 */
class ButtonBuilder
{

    /**
     * The button interpreter.
     *
     * @var ButtonInterpreter
     */
    protected $interpreter;

    /**
     * The button evaluator.
     *
     * @var ButtonEvaluator
     */
    protected $evaluator;

    /**
     * The button factory.
     *
     * @var ButtonFactory
     */
    protected $factory;

    /**
     * Create a new ButtonBuilder instance.
     *
     * @param ButtonInterpreter $interpreter
     * @param ButtonFactory     $factory
     */
    function __construct(
        ButtonInterpreter $interpreter,
        ButtonEvaluator $evaluator,
        ButtonFactory $factory
    ) {
        $this->factory     = $factory;
        $this->evaluator   = $evaluator;
        $this->interpreter = $interpreter;
    }
}
