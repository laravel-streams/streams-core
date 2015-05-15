<?php namespace Anomaly\Streams\Platform\Ui\Breadcrumb\Listener;

use Anomaly\Streams\Platform\Ui\Breadcrumb\BreadcrumbCollection;
use Illuminate\Http\Request;

/**
 * Class GuessBreadcrumbs
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Breadcrumb\Listener
 */
class GuessBreadcrumbs
{

    /**
     * The request object.
     *
     * @var Request
     */
    protected $request;

    /**
     * The breadcrumb collection.
     *
     * @var BreadcrumbCollection
     */
    protected $breadcrumbs;

    /**
     * Create a new GuessBreadcrumbs instance.
     *
     * @param Request              $request
     * @param BreadcrumbCollection $breadcrumbs
     */
    public function __construct(Request $request, BreadcrumbCollection $breadcrumbs)
    {
        $this->request     = $request;
        $this->breadcrumbs = $breadcrumbs;
    }

    /**
     * Handle the event.
     */
    public function handle()
    {
        if ($this->request->path() == 'admin/login') {
            $this->breadcrumbs->add('streams::breadcrumb.login', '#');
        }

        if ($this->request->path() == 'installer/install') {
            $this->breadcrumbs->add('streams::breadcrumb.install', '#');
        }
    }
}
