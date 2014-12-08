<?php namespace Anomaly\Streams\Platform\Ui\Table\View;

class ViewFactory
{

    protected $views = [
        'all' => [
            'slug' => 'all',
            'text' => 'misc.all',
        ]
    ];

    public function make(array $parameters)
    {
        if (isset($parameters['view']) and class_exists($parameters['view'])) {

            return app()->make($parameters['view'], $parameters);
        }

        if ($view = array_get($this->views, array_get($parameters, 'view'))) {

            $parameters = array_replace_recursive($view, array_except($parameters, 'view'));
        }

        return app()->make('Anomaly\Streams\Platform\Ui\Table\View\View', $parameters);
    }
}
 