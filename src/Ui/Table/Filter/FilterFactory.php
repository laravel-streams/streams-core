<?php namespace Anomaly\Streams\Platform\Ui\Table\Filter;

use Anomaly\Streams\Platform\Ui\Table\Filter\Contract\FilterRepositoryInterface;

/**
 * Class FilterFactory
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Filter
 */
class FilterFactory
{

    /**
     * The default filter class.
     *
     * @var string
     */
    protected $filter = 'Anomaly\Streams\Platform\Ui\Table\Filter\Type\InputFilter';

    /**
     * The filter repository.
     *
     * @var FilterRepositoryInterface
     */
    protected $filters;

    /**
     * Create a new FilterFactory instance.
     *
     * @param FilterRepositoryInterface $filters
     */
    public function __construct(FilterRepositoryInterface $filters)
    {
        $this->filters = $filters;
    }

    /**
     * Make a filter.
     *
     * @param array $parameters
     * @return mixed
     */
    public function make(array $parameters)
    {
        if ($filter = $this->filters->find(array_get($parameters, 'filter'))) {
            $parameters = array_replace_recursive($filter, array_except($parameters, 'filter'));
        }

        return app()->make(array_get($parameters, 'filter', $this->filter), $parameters);
    }
}
