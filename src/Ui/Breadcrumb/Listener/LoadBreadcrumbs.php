<?php namespace Anomaly\Streams\Platform\Ui\Breadcrumb\Listener;

use Anomaly\Streams\Platform\Ui\Breadcrumb\BreadcrumbCollection;
use Anomaly\Streams\Platform\View\ViewTemplate;

/**
 * Class LoadBreadcrumbs
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Breadcrumb\Listener
 */
class LoadBreadcrumbs
{

    /**
     * The view template.
     *
     * @var ViewTemplate
     */
    protected $template;

    /**
     * The breadcrumb collection.
     *
     * @var BreadcrumbCollection
     */
    protected $breadcrumbs;

    /**
     * Create a new LoadBreadcrumbs instance.
     *
     * @param ViewTemplate         $template
     * @param BreadcrumbCollection $breadcrumbs
     */
    public function __construct(ViewTemplate $template, BreadcrumbCollection $breadcrumbs)
    {
        $this->template    = $template;
        $this->breadcrumbs = $breadcrumbs;
    }

    /**
     * Handle the event.
     */
    public function handle()
    {
        $this->template->put('breadcrumbs', $this->breadcrumbs);
    }
}
