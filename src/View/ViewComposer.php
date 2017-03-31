<?php namespace Anomaly\Streams\Platform\View;

use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Addon\Module\Module;
use Anomaly\Streams\Platform\Addon\Theme\Theme;
use Anomaly\Streams\Platform\Application\Application;
use Anomaly\Streams\Platform\View\Event\ViewComposed;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Mobile_Detect;

/**
 * Class ViewComposer
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class ViewComposer
{

    /**
     * Runtime cache.
     *
     * @var array
     */
    protected $cache = [];

    /**
     * The view factory.
     *
     * @var Factory
     */
    protected $view;

    /**
     * The agent utility.
     *
     * @var Mobile_Detect
     */
    protected $agent;

    /**
     * The event dispatcher.
     *
     * @var Dispatcher
     */
    protected $events;

    /**
     * The current theme.
     *
     * @var Theme|null
     */
    protected $theme;

    /**
     * The active module.
     *
     * @var Module|null
     */
    protected $module;

    /**
     * The addon collection.
     *
     * @var AddonCollection
     */
    protected $addons;

    /**
     * The request object.
     *
     * @var Request
     */
    protected $request;

    /**
     * The view overrides collection.
     *
     * @var ViewOverrides
     */
    protected $overrides;

    /**
     * The application instance.
     *
     * @var Application
     */
    protected $application;

    /**
     * The view mobile overrides.
     *
     * @var ViewMobileOverrides
     */
    protected $mobiles;

    /**
     * Create a new ViewComposer instance.
     *
     * @param Factory             $view
     * @param Mobile_Detect       $agent
     * @param Dispatcher          $events
     * @param AddonCollection     $addons
     * @param ViewOverrides       $overrides
     * @param Request             $request
     * @param ViewMobileOverrides $mobiles
     * @param Application         $application
     */
    public function __construct(
        Factory $view,
        Mobile_Detect $agent,
        Dispatcher $events,
        AddonCollection $addons,
        ViewOverrides $overrides,
        Request $request,
        ViewMobileOverrides $mobiles,
        Application $application
    ) {
        $this->view        = $view;
        $this->agent       = $agent;
        $this->events      = $events;
        $this->addons      = $addons;
        $this->mobiles     = $mobiles;
        $this->request     = $request;
        $this->overrides   = $overrides;
        $this->application = $application;

        $area = $request->segment(1) == 'admin' ? 'admin' : 'standard';

        $this->theme  = $this->addons->themes->active($area);
        $this->module = $this->addons->modules->active();

        $this->mobile = $this->agent->isMobile();
    }

    /**
     * Compose the view before rendering.
     *
     * @param  View $view
     * @return View
     */
    public function compose(View $view)
    {

        if (!$this->theme || !env('INSTALLED')) {

            $this->events->fire(new ViewComposed($view));

            return $view;
        }

        $this->events->fire(new ViewComposed($view));

        return $view;
    }
}
