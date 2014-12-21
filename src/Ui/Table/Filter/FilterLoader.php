<?php namespace Anomaly\Streams\Platform\Ui\Table\Filter;

use Anomaly\Streams\Platform\Support\Evaluator;
use Anomaly\Streams\Platform\Ui\Table\Filter\Contract\FilterInterface;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class FilterLoader
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Filter
 */
class FilterLoader
{

    /**
     * The evaluator utility.
     *
     * @var \Anomaly\Streams\Platform\Support\Evaluator
     */
    protected $evaluator;

    /**
     * Create a new FilterLoader instance.
     *
     * @param Evaluator $evaluator
     */
    public function __construct(Evaluator $evaluator)
    {
        $this->evaluator = $evaluator;
    }

    /**
     * Load the view data for filters.
     *
     * @param TableBuilder $builder
     */
    public function load(TableBuilder $builder)
    {
        $table = $builder->getTable();
        $data  = $table->getData();

        $filters = array_map(
            function (FilterInterface $filter) {
                return $filter->toArray();
            },
            $table->getFilters()->all()
        );

        $filters = $this->evaluator->evaluate($filters);

        $data->put('filters', $filters);
    }
}
