<?php namespace Anomaly\Streams\Platform\Ui\Table\Filter;

class FilterFactory
{

    protected $filters = [];

    public function make(array $parameters)
    {
        if (isset($parameters['filter']) and class_exists($parameters['filter'])) {

            return app()->make($parameters['filter'], $parameters);
        }

        if ($filter = array_get($this->filters, array_get($parameters, 'filter'))) {

            $parameters = array_replace_recursive($filter, array_except($parameters, 'filter'));
        }

        return app()->make('Anomaly\Streams\Platform\Ui\Table\Filter\Filter', $parameters);
    }
}
 