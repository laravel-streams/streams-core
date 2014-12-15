<?php namespace Anomaly\Streams\Platform\Ui\Table\Filter;

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
    protected $filter = 'Anomaly\Streams\Platform\Ui\Table\Filter\Filter';

    /**
     * Available filter defaults.
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
     * Make a filter.
     *
     * @param array $parameters
     * @return mixed
     */
    public function make(array $parameters)
    {
        if (isset($parameters['filter']) && class_exists($parameters['filter'])) {
            return app()->make($parameters['filter'], $parameters);
        }

        if ($filter = array_get($this->filters, array_get($parameters, 'filter'))) {
            $parameters = array_replace_recursive($filter, array_except($parameters, 'filter'));
        }

        return app()->make(array_get($parameters, 'filter', $this->filter), $parameters);
    }
}
