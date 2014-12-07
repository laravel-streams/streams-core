<?php namespace Anomaly\Streams\Platform\Ui\Table\Row;

class RowFactory
{

    public function make(array $parameters)
    {
        return app()->make('Anomaly\Streams\Platform\Ui\Table\Row\Row', $parameters);
    }
}
 