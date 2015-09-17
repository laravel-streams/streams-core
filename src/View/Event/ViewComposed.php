<?php

namespace Anomaly\Streams\Platform\View\Event;

use Illuminate\View\View;

/**
 * Class ViewComposed.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\View\Event
 */
class ViewComposed
{
    /**
     * The view object.
     *
     * @var View
     */
    protected $view;

    /**
     * Create a new ViewComposed instance.
     *
     * @param View $view
     */
    public function __construct(View $view)
    {
        $this->view = $view;
    }

    /**
     * Get the view.
     *
     * @return View
     */
    public function getView()
    {
        return $this->view;
    }
}
