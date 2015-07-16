<?php namespace Anomaly\Streams\Platform\View;

use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Addon\Theme\ThemeCollection;
use Anomaly\Streams\Platform\View\Event\ViewComposed;
use Illuminate\Events\Dispatcher;
use Illuminate\View\View;
use Jenssegers\Agent\Agent;

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
     * The agent utility.
     *
     * @var Agent
     */
    protected $agent;

    /**
     * The event dispatcher.
     *
     * @var Dispatcher
     */
    protected $events;

    /**
     * The theme collection.
     *
     * @var ThemeCollection
     */
    protected $themes;

    /**
     * The module collection.
     *
     * @var ModuleCollection
     */
    protected $modules;

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
     * @param Agent               $agent
     * @param Dispatcher          $events
     * @param ThemeCollection     $themes
     * @param ModuleCollection    $modules
     * @param ViewOverrides       $overrides
     * @param ViewMobileOverrides $mobiles
     */
    function __construct(
        Agent $agent,
        Dispatcher $events,
        ThemeCollection $themes,
        ModuleCollection $modules,
        ViewOverrides $overrides,
        ViewMobileOverrides $mobiles
    ) {
        $this->agent     = $agent;
        $this->events    = $events;
        $this->themes    = $themes;
        $this->modules   = $modules;
        $this->mobiles   = $mobiles;
        $this->overrides = $overrides;

        $this->mobile = $agent->isMobile();
    }

    /**
     * Compose the view before rendering.
     *
     * @param  View $view
     * @return View
     */
    public function compose(View $view)
    {
        $theme  = $this->themes->current();
        $module = $this->modules->active();

        if (!$theme) {
            return $view;
        }

        $mobile    = $this->mobiles->get($theme->getNamespace(), []);
        $overrides = $this->overrides->get($theme->getNamespace(), []);

        if ($this->mobile && $path = array_get($mobile, $view->getName(), null)) {
            $view->setPath($path);
        } elseif ($path = array_get($overrides, $view->getName(), null)) {
            $view->setPath($path);
        }

        if ($module) {

            $mobile    = $this->mobiles->get($module->getNamespace(), []);
            $overrides = $this->overrides->get($module->getNamespace(), []);

            if ($this->mobile && $path = array_get($mobile, $view->getName(), null)) {
                $view->setPath($path);
            } elseif ($path = array_get($overrides, $view->getName(), null)) {
                $view->setPath($path);
            }
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
         * If the view is already in
         * the theme then skip it.
         */
        if (starts_with($view->getName(), 'theme::') || str_is('*.theme.*::*', $view->getName())) {

            $parts = explode('::', $view->getName());

            return end($parts);
        }

        /**
         * If the view is a streams view then
         * it's real easy to guess what the
         * override path should be.
         */
        if (starts_with($view->getName(), 'streams::')) {
            return str_replace('::', '/', $view->getName());
        }

        /**
         * If the view starts with module:: then
         * look up the active module.
         */
        if (starts_with($view->getName(), 'module::')) {

            $module = $this->modules->active();

            $path = str_replace('.', '/', $module->getNamespace());
            $path .= str_replace('module::', '', '/' . $view->getName());

            return $path;
        }

        /**
         * If the view uses a dot syntax namespace then
         * transform it all into the override view path.
         */
        if (str_contains($view->getName(), '::')) {
            return str_replace(['.', '::'], '/', $view->getName());
        }

        return null;
    }
}
