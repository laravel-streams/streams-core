<?php namespace Anomaly\Streams\Platform\Ui\Table\View;

class ViewFactory
{

    protected $views = [
        'all' => [
            'slug' => 'all',
            'text' => 'misc.all',
            'view' => 'Anomaly\Streams\Platform\Ui\Table\View\View',
        ]
    ];

    public function make(array $parameters)
    {
        if (class_exists($parameters['view'])) {

            return app()->make($parameters['view'], $parameters);
        }

        if ($view = array_get($this->views, array_get($parameters, 'view'))) {

            $parameters = array_merge($view, array_except($parameters, 'view'));

            return app()->make($parameters['view'], $parameters);
        }

        return app()->make('Anomaly\Streams\Platform\Ui\Table\View\View', $parameters);
    }
}
 