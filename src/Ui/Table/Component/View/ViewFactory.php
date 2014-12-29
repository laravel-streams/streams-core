<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\View;

use Anomaly\Streams\Platform\Support\Hydrator;
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
     * The hydrator utility.
     *
     * @var Hydrator
     */
    protected $hydrator;

    /**
     * Create a new ViewFactory instance.
     *
     * @param ViewRegistry $views
     * @param Hydrator     $hydrator
     */
    public function __construct(ViewRegistry $views, Hydrator $hydrator)
    {
        $this->views    = $views;
        $this->hydrator = $hydrator;
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

        $this->hydrator->hydrate($view, $parameters);

        return $view;
    }
}
