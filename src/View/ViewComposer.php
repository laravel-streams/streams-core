<?php namespace Anomaly\Streams\Platform\View;

use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Addon\Module\Module;
use Anomaly\Streams\Platform\Addon\Theme\Theme;
use Anomaly\Streams\Platform\View\Event\ViewComposed;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Mobile_Detect;

/**
 * Class ViewComposer
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Support
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
     * The view mobile overrides.
     *
     * @var ViewMobileOverrides
     */
    protected $mobiles;

    /**
     * @param Factory             $view
     * @param Mobile_Detect       $agent
     * @param Dispatcher          $events
     * @param AddonCollection     $addons
     * @param Request             $request
     * @param ViewOverrides       $overrides
     * @param ViewMobileOverrides $mobiles
     */
    function __construct(
        Factory $view,
        Mobile_Detect $agent,
        Dispatcher $events,
        AddonCollection $addons,
        ViewOverrides $overrides,
        Request $request,
        ViewMobileOverrides $mobiles
    ) {
        $this->view      = $view;
        $this->agent     = $agent;
        $this->events    = $events;
        $this->addons    = $addons;
        $this->mobiles   = $mobiles;
        $this->request   = $request;
        $this->overrides = $overrides;

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
        if (!$this->theme) {

            $this->events->fire(new ViewComposed($view));

            return $view;
        }

        $mobile    = $this->mobiles->get($this->theme->getNamespace(), []);
        $overrides = $this->overrides->get($this->theme->getNamespace(), []);

        if ($this->mobile && $path = array_get($mobile, $view->getName(), null)) {
            $view->setPath($path);
        } elseif ($path = array_get($overrides, $view->getName(), null)) {
            $view->setPath($path);
        }

        if ($this->module) {

            $mobile    = $this->mobiles->get($this->module->getNamespace(), []);
            $overrides = $this->overrides->get($this->module->getNamespace(), []);

            if ($this->mobile && $path = array_get($mobile, $view->getName(), null)) {
                $view->setPath($path);
            } elseif ($path = array_get($overrides, $view->getName(), null)) {
                $view->setPath($path);
            }
        }

        if ($overload = $this->getOverloadPath($view)) {
            $view->setPath($overload);
        }

        $this->events->fire(new ViewComposed($view));

        return $view;
    }

    /**
     * Get the override view path.
     *
     * @param  $view
     * @return null|string
     */
    public function getOverloadPath(View $view)
    {

        /**
         * We can only overload namespaced
         * views right now.
         */
        if (!str_contains($view->getName(), '::')) {
            return null;
        }

        /**
         * Split the view into it's
         * namespace and path.
         */
        list($namespace, $path) = explode('::', $view->getName());

        $path = str_replace('.', '/', $path);

        /**
         * If the view is already in
         * the theme then skip it.
         */
        if ($namespace == 'theme' || str_is('*.theme.*', $namespace)) {
            return null;
        }

        /**
         * If the view is a streams view then
         * it's real easy to guess what the
         * override path should be.
         */
        if ($namespace == 'streams') {
            $path = $this->theme->getNamespace('streams/' . $path);
        }

        /**
         * If the view uses a dot syntax namespace then
         * transform it all into the override view path.
         */
        if ($addon = $this->addons->get($namespace)) {
            $path = $this->theme->getNamespace(
                "addon/{$addon->getVendor()}/{$addon->getSlug()}-{$addon->getType()}/" . $path
            );
        }

        if ($this->view->exists($path)) {
            return $path;
        }

        return null;
    }
}
