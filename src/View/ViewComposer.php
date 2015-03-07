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
     * Create a new ViewComposer instance.
     *
     * @param Agent            $agent
     * @param Dispatcher       $events
     * @param ThemeCollection  $themes
     * @param ModuleCollection $modules
     */
    function __construct(Agent $agent, Dispatcher $events, ThemeCollection $themes, ModuleCollection $modules)
    {
        $this->agent   = $agent;
        $this->events  = $events;
        $this->themes  = $themes;
        $this->modules = $modules;
    }

    /**
     * Compose the view before rendering.
     *
     * @param  View $view
     * @return View|mixed
     */
    public function compose(View $view)
    {
        $isMobile = $this->agent->isMobile();

        $environment = $view->getFactory();

        $path = $this->getOverloadPath($view);

        $result = null;

        if ($isMobile) {

            $mobileView     = str_replace('::', '::mobile/', $view->getName());
            $mobileOverload = "theme::override/{$mobileView}";

            if ($environment->exists($mobileView)) {
                $result = $mobileView;
            }

            if ($environment->exists($mobileOverload)) {
                $result = $mobileOverload;
            }
        }

        $override = "theme::override/{$path}";

        if (!$result && $environment->exists($override)) {
            $result = $override;
        }

        if ($result) {
            $view->setPath($environment->getFinder()->find($result));
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
