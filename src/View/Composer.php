<?php namespace Anomaly\Streams\Platform\View;

use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Addon\Theme\ThemeCollection;
use Illuminate\View\View;
use Jenssegers\Agent\Agent;

/**
 * Class Composer
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Support
 */
class Composer
{

    /**
     * The agent utility.
     *
     * @var Agent
     */
    protected $agent;

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
     * Create a new Composer instance.
     *
     * @param Agent            $agent
     * @param ThemeCollection  $themes
     * @param ModuleCollection $modules
     */
    function __construct(Agent $agent, ThemeCollection $themes, ModuleCollection $modules)
    {
        $this->agent   = $agent;
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
        $overload = $this->getOverloadPath($view);

        if ($this->agent->isMobile()) {
            $overload = "mobile/{$overload}";
        }

        $environment = $view->getFactory();

        if ($overload && $environment->exists($overload)) {
            $view->setPath($environment->getFinder()->find($overload));
        }

        return $view;
    }

    /**
     * Get the overload view path.
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
         * overload path should be.
         */
        if (starts_with($view->getName(), 'streams::')) {

            $path = str_replace('::', '/', $view->getName());

            return "overload/{$path}";
        }

        /**
         * If the view starts with module:: then
         * look up the active module.
         */
        if (starts_with($view->getName(), 'module::')) {

            $module = $this->modules->active();

            $path = str_replace('.', '/', $module->getNamespace());
            $path .= str_replace('module::', '', '/' . $view->getName());

            return "overload/{$path}";
        }

        /**
         * If the view uses a dot syntax namespace then
         * transform it all into the overload view path.
         */
        if (str_contains($view->getName(), '::')) {

            $path = str_replace(['.', '::'], '/', $view->getName());

            return "overload/{$path}";
        }

        return null;
    }
}
