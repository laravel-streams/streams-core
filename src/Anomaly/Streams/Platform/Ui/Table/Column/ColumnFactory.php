<?php namespace Anomaly\Streams\Platform\Ui\Table\Column;

class ColumnFactory
{

    public function make(array $parameters)
    {
        if (!isset($parameters['column'])) {

            $parameters['column'] = 'Anomaly\Streams\Platform\Ui\Table\Column\Column';
        }

        if (isset($parameters['column']) and class_exists($parameters['column'])) {

            return app()->make($parameters['column'], $parameters);
        }

        // TODO: Explore this perhaps it could be cool.
        /*if ($column = array_get($parameters, 'column') and $column = $this->columns->find($column)) {

            $column = array_merge($column, array_except($parameters, 'column'));

            return app()->make($column['column'], $column);
        }*/

        throw new \Exception('A column could not be created with the provided parameters.');
    }
}
 