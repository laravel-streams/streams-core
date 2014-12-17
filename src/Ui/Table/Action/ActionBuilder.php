<?php namespace Anomaly\Streams\Platform\Ui\Table\Action;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Laracasts\Commander\CommanderTrait;

/**
 * Class ActionBuilder
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Action
 */
class ActionBuilder
{

    use CommanderTrait;

    /**
     * The action converter.
     *
     * @var ActionConverter
     */
    protected $converter;

    /**
     * The action evaluator.
     *
     * @var ActionEvaluator
     */
    protected $evaluator;

    /**
     * The action factory.
     *
     * @var ActionFactory
     */
    protected $factory;

    /**
     * Create a new ActionBuilder instance.
     *
     * @param ActionConverter $converter
     * @param ActionEvaluator $evaluator
     * @param ActionFactory   $factory
     */
    function __construct(ActionConverter $converter, ActionEvaluator $evaluator, ActionFactory $factory)
    {
        $this->factory   = $factory;
        $this->converter = $converter;
        $this->evaluator = $evaluator;
    }

    /**
     * Build actions.
     *
     * @param TableBuilder $builder
     */
    public function build(TableBuilder $builder)
    {
        $table   = $builder->getTable();
        $actions = $table->getActions();

        foreach ($builder->getActions() as $key => $parameters) {

            $parameters = $this->converter->standardize($key, $parameters);

            $action = $this->factory->make($parameters);

            $actions->put($action->getSlug(), $action);
        }
    }
}
