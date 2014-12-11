<?php namespace Anomaly\Streams\Platform\Ui\Table\Header;

class HeaderFactory
{

    public function make(array $parameters)
    {
        if (isset($parameters['header']) && class_exists($parameters['header'])) {

            return app()->make($parameters['header'], $parameters);
        }

        return app()->make('Anomaly\Streams\Platform\Ui\Table\Header\Header', $parameters);
    }
}
 