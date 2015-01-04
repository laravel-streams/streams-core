<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\View;

/**
 * Class ViewRegistry
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
            'text' => 'streams::misc.all',
            'view' => 'Anomaly\Streams\Platform\Ui\Table\Component\View\Type\ViewAll',
        ],
        'recently_created' => [
            'slug' => 'recently_created',
            'text' => 'streams::misc.recently_created',
            'view' => 'Anomaly\Streams\Platform\Ui\Table\Component\View\Type\ViewRecentlyCreated',
        ]
    ];

    /**
     * Get a view.
     *
     * @param  $view
     * @return mixed
     */
    public function get($view)
    {
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
