<?php namespace Anomaly\Streams\Platform\Ui\Table\Filter;

class FilterFactory
{

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

    public function make(array $parameters)
    {
        if (isset($parameters['filter']) and class_exists($parameters['filter'])) {

            return app()->make($parameters['filter'], $parameters);
        }

        if ($filter = array_get($this->filters, array_get($parameters, 'filter'))) {

            $parameters = array_replace_recursive($filter, array_except($parameters, 'filter'));
        }

        return app()->make(
            array_get($parameters, 'filter', 'Anomaly\Streams\Platform\Ui\Table\Filter\Filter'),
            $parameters
        );
    }
}
 