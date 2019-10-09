<?php

namespace Anomaly\Streams\Platform\View\Listener;

use Anomaly\Streams\Platform\View\Event\TemplateDataIsLoading;
use Anomaly\Streams\Platform\View\ViewIncludes;
use Anomaly\Streams\Platform\View\ViewTemplate;

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
     */
    public function __construct(ViewTemplate $template, ViewIncludes $includes)
    {
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

            event(new TemplateDataIsLoading($this->template));

            \View::share('template', $this->template);

            $this->template->setLoaded(true);
        }
    }
}
