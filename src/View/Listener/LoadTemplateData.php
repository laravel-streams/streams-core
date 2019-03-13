<?php namespace Anomaly\Streams\Platform\View\Listener;

use Anomaly\Streams\Platform\View\Event\RegisteringTwigPlugins;
use Anomaly\Streams\Platform\View\Event\TemplateDataIsLoading;
use Anomaly\Streams\Platform\View\Event\ViewComposed;
use Anomaly\Streams\Platform\View\Twig\Bridge;
use Anomaly\Streams\Platform\View\ViewIncludes;
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
     * @var ViewIncludes
     */
    protected $includes;

    /**
     * Create a new LoadTemplateData instance.
     *
     * @param ViewTemplate $template
     * @param ViewIncludes $includes
     * @param Dispatcher $events
     * @param Bridge $twig
     */
    public function __construct(ViewTemplate $template, ViewIncludes $includes, Dispatcher $events, Bridge $twig)
    {
        $this->twig     = $twig;
        $this->events   = $events;
        $this->template = $template;
        $this->includes = $includes;
    }

    /**
     * Handle the event.
     */
    public function handle()
    {
        if (!$this->template->isLoaded()) {

            $this->template->set('includes', $this->includes);

            event(new RegisteringTwigPlugins($this->twig));
            event(new TemplateDataIsLoading($this->template));

            $this->template->setLoaded(true);
        }
    }
}
