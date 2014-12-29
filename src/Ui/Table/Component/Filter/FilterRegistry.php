<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter;

/**
 * Class FilterRegistry
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Component\Filter
 */
class FilterRegistry
{

    /**
     * Available filters.
     *
     * @var array
     */
    protected $filters = [
        'input'  => [
            'slug'   => 'input',
            'filter' => 'Anomaly\Streams\Platform\Ui\Table\Component\Filter\Type\InputFilter',
        ],
        'select' => [
            'slug'   => 'select',
            'filter' => 'Anomaly\Streams\Platform\Ui\Table\Component\Filter\Type\SelectFilter',
        ],
        'field'  => [
            'filter' => 'Anomaly\Streams\Platform\Ui\Table\Component\Filter\Type\FieldFilter',
        ]
    ];

    /**
     * Get a filter.
     *
     * @param  $filter
     * @return array
     */
    public function get($filter)
    {
        return array_get($this->filters, $filter);
    }

    /**
     * Register a filter.
     *
     * @param       $filter
     * @param array $parameters
     * @return $this
     */
    public function register($filter, array $parameters)
    {
        array_set($this->filters, $filter, $parameters);

        return $this;
    }
}
