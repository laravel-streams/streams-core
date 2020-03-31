<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\View;

use Anomaly\Streams\Platform\Support\Facades\Hydrator;
use Anomaly\Streams\Platform\Ui\Table\Component\View\Contract\ViewInterface;
use Illuminate\Contracts\Container\Container;

/**
 * Class ViewFactory
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class ViewFactory
{

    /**
     * The default view class.
     *
     * @var string
     */
    protected $view = View::class;

    /**
     * The services container.
     *
     * @var Container
     */
    protected $container;

    /**
     * Create a new ViewFactory instance.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Make a view.
     *
     * @param  array         $parameters
     * @return ViewInterface
     */
    public function make(array $parameters)
    {
        if (!class_exists(array_get($parameters, 'view'))) {
            array_set($parameters, 'view', $this->view);
        }

        Hydrator::hydrate(
            $view = $this->container->make(array_get($parameters, 'view'), $parameters),
            $parameters
        );

        return $view;
    }
}
