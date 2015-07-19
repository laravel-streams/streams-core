<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\View;

use Anomaly\Streams\Platform\Support\Hydrator;
use Anomaly\Streams\Platform\Ui\Table\Component\View\Contract\ViewInterface;
use Illuminate\Container\Container;

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
     * The hydrator utility.
     *
     * @var Hydrator
     */
    protected $hydrator;

    /**
     * The services container.
     *
     * @var Container
     */
    protected $container;

    /**
     * Create a new ViewFactory instance.
     *
     * @param ViewRegistry $views
     * @param Hydrator     $hydrator
     * @param Container    $container
     */
    public function __construct(ViewRegistry $views, Hydrator $hydrator, Container $container)
    {
        $this->views     = $views;
        $this->hydrator  = $hydrator;
        $this->container = $container;
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

        if (!class_exists(array_get($parameters, 'view'))) {
            $parameters['view'] = $this->view;
        }

        $view = $this->container->make(array_get($parameters, 'view'), $parameters);

        $this->hydrator->hydrate($view, $parameters);

        return $view;
    }
}
