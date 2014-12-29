<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\View;

use Anomaly\Streams\Platform\Ui\Table\Component\View\Contract\ViewInterface;

/**
 * Class ViewFactory
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Component\View
 */
class ViewFactory
{

    /**
     * The default view class.
     *
     * @var string
     */
    protected $view = 'Anomaly\Streams\Platform\Ui\Table\Component\View\View';

    /**
     * The view registry.
     *
     * @var ViewRegistry
     */
    protected $views;

    /**
     * Create a new ViewFactory instance.
     *
     * @param ViewRegistry $views
     */
    public function __construct(ViewRegistry $views)
    {
        $this->views = $views;
    }

    /**
     * Make a view.
     *
     * @param  array $parameters
     * @return ViewInterface
     */
    public function make(array $parameters)
    {
        if ($view = $this->views->get(array_get($parameters, 'view'))) {
            $parameters = array_replace_recursive($view, array_except($parameters, 'view'));
        }

        $view = app()->make(array_get($parameters, 'view', $this->view), $parameters);

        $this->hydrate($view, $parameters);

        return $view;
    }

    /**
     * Hydrate the view with it's remaining parameters.
     *
     * @param ViewInterface $view
     * @param array         $parameters
     */
    protected function hydrate(ViewInterface $view, array $parameters)
    {
        foreach ($parameters as $parameter => $value) {

            $method = camel_case('set_' . $parameter);

            if (method_exists($view, $method)) {
                $view->{$method}($value);
            }
        }
    }
}
