<?php namespace Anomaly\Streams\Platform\Ui\Table\Filter;

class FilterFactory
{

    protected $filters;

    function __construct(FilterRepository $filters)
    {
        $this->filters = $filters;
    }

    public function make(array $parameters)
    {
        if (isset($parameters['filter']) and class_exists($parameters['filter'])) {

            return app()->make($parameters['filter'], $parameters);
        }

        if ($filter = array_get($parameters, 'filter') and $filter = $this->filters->find($filter)) {

            $filter = array_merge($filter, array_except($parameters, 'filter'));

            return app()->make($filter['filter'], $filter);
        }

        throw new \Exception('A filter could not be created with the provided parameters.');
    }
}
 