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
     * @param Hydrator  $hydrator
     * @param Container $container
     */
    public function __construct(Hydrator $hydrator, Container $container)
    {
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
        if (!class_exists(array_get($parameters, 'view'))) {
            array_set($parameters, 'view', $this->view);
        }

        $this->hydrator->hydrate(
            $view = $this->container->make(array_get($parameters, 'view'), $parameters),
            $parameters
        );

        return $view;
    }
}
