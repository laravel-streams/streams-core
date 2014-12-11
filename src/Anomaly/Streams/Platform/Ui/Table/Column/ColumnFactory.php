<?php namespace Anomaly\Streams\Platform\Ui\Table\Column;

class ColumnFactory
{

    public function make(array $parameters)
    {
        if (!isset($parameters['column'])) {

            $parameters['column'] = 'Anomaly\Streams\Platform\Ui\Table\Column\Column';
        }

        if (isset($parameters['column']) && class_exists($parameters['column'])) {

            return app()->make($parameters['column'], $parameters);
        }
    }
}
 