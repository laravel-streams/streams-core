<?php namespace Anomaly\Streams\Platform\Ui\Table\Header;

class HeaderFactory
{

    protected $headers = [];

    public function make(array $parameters)
    {
        if (isset($parameters['header']) and class_exists($parameters['header'])) {

            return app()->make($parameters['header'], $parameters);
        }

        if ($header = array_get($this->headers, array_get($parameters, 'header'))) {

            $parameters = array_replace_recursive($header, array_except($parameters, 'header'));
        }

        return app()->make('Anomaly\Streams\Platform\Ui\Table\Header\Header', $parameters);
    }
}
 