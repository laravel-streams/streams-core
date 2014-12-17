<?php namespace Anomaly\Streams\Platform\Ui\Table\Filter;

use Anomaly\Streams\Platform\Ui\Table\Filter\Contract\FilterInterface;
use Anomaly\Streams\Platform\Ui\Table\Filter\Contract\FilterRepositoryInterface;

/**
 * Class FilterRepository
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Filter
 */
class FilterRepository implements FilterRepositoryInterface
{

    /**
     * Available filters.
     *
     * @var array
     */
    protected $filters = [
        'input'  => [
            'slug'   => 'input',
            'filter' => 'Anomaly\Streams\Platform\Ui\Table\Filter\Type\InputFilter',
        ],
        'select' => [
            'slug'   => 'select',
            'filter' => 'Anomaly\Streams\Platform\Ui\Table\Filter\Type\SelectFilter',
        ],
        'field'  => [
            'filter' => 'Anomaly\Streams\Platform\Ui\Table\Filter\Type\FieldFilter',
        ]
    ];

    /**
     * Find a filter.
     *
     * @param $filter
     * @return FilterInterface
     */
    public function find($filter)
    {
        return array_get($this->filters, $filter);
    }
}
