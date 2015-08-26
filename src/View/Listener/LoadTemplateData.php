<?php namespace Anomaly\Streams\Platform\View\Listener;

use Anomaly\Streams\Platform\View\Event\TemplateDataIsLoading;
use Anomaly\Streams\Platform\View\Event\ViewComposed;
use Anomaly\Streams\Platform\View\ViewTemplate;
use Illuminate\Contracts\Events\Dispatcher;

/**
 * Class LoadTemplateData
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\View\Listener
 */
class LoadTemplateData
{

    /**
     * The event dispatcher.
     *
     * @var Dispatcher
     */
    private $events;

    /**
     * The view template.
     *
     * @var ViewTemplate
     */
    protected $template;

    /**
     * Create a new LoadTemplateData instance.
     *
     * @param ViewTemplate $template
     * @param Dispatcher   $events
     */
    public function __construct(ViewTemplate $template, Dispatcher $events)
    {
        $this->template = $template;
        $this->events   = $events;
    }

    /**
     * Handle the event.
     *
     * @param ViewComposed $event
     */
    public function handle(ViewComposed $event)
    {
        $view = $event->getView();

        if (array_get($view->getData(), 'template')) {
            return;
        }

        $this->events->fire(new TemplateDataIsLoading($this->template));

        if (array_merge($view->getFactory()->getShared(), $view->getData())) {
            $view['template'] = $this->template;
        }
    }
}
