<?php namespace Anomaly\Streams\Platform\Ui\Table\View;

/**
 * Class ViewFactory
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\View
 */
class ViewFactory
{

    /**
     * The default view class.
     *
     * @var string
     */
    protected $view = 'Anomaly\Streams\Platform\Ui\Table\View\View';

    /**
     * Available view defaults.
     *
     * @var array
     */
    protected $views = [
        'all' => [
            'slug' => 'all',
            'text' => 'streams::misc.all',
        ]
    ];

    /**
     * Make a view.
     *
     * @param array $parameters
     * @return mixed
     */
    public function make(array $parameters)
    {
        if (isset($parameters['view']) && class_exists($parameters['view'])) {
            return app()->make($parameters['view'], $parameters);
        }

        if ($view = array_get($this->views, array_get($parameters, 'view'))) {
            $parameters = array_replace_recursive($view, array_except($parameters, 'view'));
        }

        return app()->make($this->view, $parameters);
    }
}
