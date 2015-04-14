<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Action;

use Anomaly\Streams\Platform\Ui\Table\Component\Action\Predict\SortablePredictor;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class ActionPredictor
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Action
 */
class ActionPredictor
{

    /**
     * The sortable predictor.
     *
     * @var SortablePredictor
     */
    protected $sortable;

    /**
     * Create a new ActionPredictor instance.
     *
     * @param SortablePredictor $sortable
     */
    public function __construct(SortablePredictor $sortable)
    {
        $this->sortable = $sortable;
    }

    /**
     * Predicting for actions.
     *
     * @param TableBuilder $builder
     */
    public function predict(TableBuilder $builder)
    {
        $this->sortable->predict($builder);
    }
}
