<?php namespace Anomaly\Streams\Platform\Ui\Table\Action;

use Anomaly\Streams\Platform\Support\Evaluator;
use Anomaly\Streams\Platform\Ui\Table\Action\Contract\ActionInterface;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class ActionLoader
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Action
 */
class ActionLoader
{

    /**
     * The evaluator utility.
     *
     * @var \Anomaly\Streams\Platform\Support\Evaluator
     */
    protected $evaluator;

    /**
     * Create a new ActionLoader instance.
     *
     * @param Evaluator $evaluator
     */
    public function __construct(Evaluator $evaluator)
    {
        $this->evaluator = $evaluator;
    }

    /**
     * Load view data for actions.
     *
     * @param TableBuilder $builder
     */
    public function load(TableBuilder $builder)
    {
        $table = $builder->getTable();
        $data  = $table->getData();

        $actions = array_map(
            function (ActionInterface $action) {
                return $action->getTableData();
            },
            $table->getActions()->all()
        );

        $actions = $this->evaluator->evaluate($actions);

        $data->put('actions', $actions);
    }
}
