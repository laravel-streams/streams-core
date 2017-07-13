<?php namespace Anomaly\Streams\Platform\View\Listener;

use Anomaly\Streams\Platform\Support\Decorator;
use Anomaly\Streams\Platform\View\Event\RegisteringTwigPlugins;
use Anomaly\Streams\Platform\View\Event\TemplateDataIsLoading;
use Anomaly\Streams\Platform\View\Event\ViewComposed;
use Anomaly\Streams\Platform\View\Twig\Bridge;
use Anomaly\Streams\Platform\View\ViewTemplate;
use Illuminate\Contracts\Events\Dispatcher;

/**
 * Class LoadTemplateData
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class LoadTemplateData
{

    /**
     * The Twig instance.
     *
     * @var Bridge
     */
    protected $twig;

    /**
     * The event dispatcher.
     *
     * @var Dispatcher
     */
    protected $events;

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
     * @param Bridge       $twig
     */
    public function __construct(ViewTemplate $template, Dispatcher $events, Bridge $twig)
    {
        $this->twig     = $twig;
        $this->events   = $events;
        $this->template = $template;
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

        if (!$this->template->isLoaded()) {
            $this->events->fire(new RegisteringTwigPlugins($this->twig));
            $this->events->fire(new TemplateDataIsLoading($this->template));

            $this->template->setLoaded(true);
        }

        if (array_merge($view->getFactory()->getShared(), $view->getData())) {
            $view['template'] = (new Decorator())->decorate($this->template);
        }
    }
}
