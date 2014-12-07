<?php namespace Anomaly\Streams\Platform\Ui\Table\Header;

class HeaderFactory
{

    public function make(array $parameters)
    {
        if (!isset($parameters['header'])) {

            $parameters['header'] = 'Anomaly\Streams\Platform\Ui\Table\Header\Header';
        }

        if (isset($parameters['header']) and class_exists($parameters['header'])) {

            return app()->make($parameters['header'], $parameters);
        }
    }
}
 