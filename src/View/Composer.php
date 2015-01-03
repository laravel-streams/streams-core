<?php namespace Anomaly\Streams\Platform\View;

use Anomaly\Streams\Platform\Addon\Addon;
use Illuminate\View\Factory;
use Illuminate\View\View;

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
     * Compose the view before rendering.
     *
     * @param  View $view
     * @return View|mixed
     */
    public function compose(View $view)
    {
        $view = $this->overloadView($view);

        return $view;
    }

    /**
     * Overload the view path.
     *
     * @param  $view
     * @return mixed
     */
    public function overloadView(View $view)
    {
        $environment = $view->getFactory();

        /**
         * If the view is already in the theme just
         * do a quick check to see if the mobile
         * override comes into play.
         */
        if (starts_with($view->getName(), 'theme::')) {
            $mobilePath = str_replace('theme::', 'theme::mobile/', $view->getName());

            $this->setMobileIfExists($mobilePath, $environment, $view);

            return $view;
        }

        /**
         * If the view path does not contain a namespace
         * separator then it is a core streams view.
         *
         * Otherwise it is an addon view and needs to be
         * split up into it's addon / type components.
         */
        if (!str_contains($view->getName(), '::')) {
            // If there is no namespace the default
            // hint / location is streams.
            $path       = "streams/{$view->getName()}";
            $mobilePath = "streams/mobile/{$view->getName()}";
        } else {
            list($namespace, $path) = explode('::', $view->getName());

            /**
             * If the namespace contains a dot it is a
             * typical type.slug notation.
             *
             * If it does not then it is a shortcut for
             * the active module / theme.
             */
            if (str_contains($namespace, '.')) {
                list($type, $slug) = explode('.', $namespace);
            } elseif (in_array($namespace, ['distribution', 'module', 'theme'])) {

                // If the namespace is a shortcut for an "active" addon
                // then resolve it through the IoC registered addon.
                $addon = null;

                if (!$addon instanceof Addon) {
                    return $view;
                }

                $type = $addon->getType();
                $slug = $addon->getSlug();
            } else {

                return null;
            }

            // Create the override paths.
            $path       = "{$type}/{$slug}/{$path}";
            $mobilePath = "{$type}/{$slug}/mobile/{$path}";
        }

        /**
         * Look for the override paths in the theme.
         * If the agent says we have got a mobile
         * visitor then look for the mobile version
         * at this time too.
         */
        $path       = "theme::overload/{$path}";
        $mobilePath = "theme::overload/{$mobilePath}";

        if ($path && $environment->exists($path)) {
            $view->setPath($environment->getFinder()->find($path));
        }

        $this->setMobileIfExists($mobilePath, $environment, $view);

        return $view;
    }

    /**
     * If the mobile path exists then use it!
     *
     * @param         $mobilePath
     * @param Factory $environment
     * @param View    $view
     */
    protected function setMobileIfExists($mobilePath, Factory $environment, View $view)
    {
        if (app('agent')->isMobile() && $mobilePath && $environment->exists($mobilePath)) {
            $view->setPath($environment->getFinder()->find($mobilePath));
        }
    }
}
