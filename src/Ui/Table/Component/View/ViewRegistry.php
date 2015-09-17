<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\View;

use Anomaly\Streams\Platform\Ui\Table\Component\View\Type\All;
use Anomaly\Streams\Platform\Ui\Table\Component\View\Type\RecentlyCreated;

/**
 * Class ViewRegistry.
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Component\View
 */
class ViewRegistry
{
    /**
     * Available views.
     *
     * @var array
     */
    protected $views = [
        'all'              => [
            'slug' => 'all',
            'text' => 'streams::view.all',
            'view' => All::class,
        ],
        'recently_created' => [
            'slug' => 'recently_created',
            'text' => 'streams::view.recently_created',
            'view' => RecentlyCreated::class,
        ],
    ];

    /**
     * Get a view.
     *
     * @param  $view
     * @return null|array
     */
    public function get($view)
    {
        if (! $view) {
            return;
        }

        return array_get($this->views, $view);
    }

    /**
     * Register a view.
     *
     * @param       $view
     * @param array $parameters
     * @return $this
     */
    public function register($view, array $parameters)
    {
        array_set($this->views, $view, $parameters);

        return $this;
    }
}
