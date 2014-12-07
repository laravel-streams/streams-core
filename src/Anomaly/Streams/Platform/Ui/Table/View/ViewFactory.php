<?php namespace Anomaly\Streams\Platform\Ui\Table\View;

use Anomaly\Streams\Platform\Ui\Table\View\Contract\ViewInterface;

class ViewFactory
{

    protected $views;

    function __construct(ViewRepository $views)
    {
        $this->views = $views;
    }

    public function make(array $parameters)
    {
        if (isset($parameters['view']) and class_exists($parameters['view'])) {

            return app()->make($parameters['view'], $parameters);
        }

        if ($view = array_get($parameters, 'view') and $view = $this->views->find($view)) {

            $view = array_merge($view, array_except($parameters, 'view'));

            return app()->make($view['view'], $view);
        }

        return app()->make('Anomaly\Streams\Platform\Ui\Table\View\View', $parameters);
    }
}
 