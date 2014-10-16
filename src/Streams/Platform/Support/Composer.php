<?php namespace Streams\Platform\Support;

use Illuminate\View\View;
use Jenssegers\Agent\Agent;

class Composer
{
    /**
     * The user agent detection class.
     *
     * @var
     */
    protected $agent;

    /**
     * Create a new Composer instance.
     *
     * @param Agent $agent
     */
    function __construct(Agent $agent)
    {
        $this->agent = $agent;
    }

    /**
     * Compose the view before rendering.
     *
     * @param View $view
     * @return View|mixed
     */
    public function compose(View $view)
    {
        $view = $this->overloadView($view);

        if ($this->agent->isMobile()) {

            $view = $this->overloadMobileView($view);

        }

        return $view;
    }

    /**
     * Overload the view path.
     *
     * @param $view
     * @return mixed
     */
    public function overloadView(View $view)
    {
        // If this is a theme view just return as is.
        if (starts_with('theme::', $view->getName())) {
            return $view;
        }

        $environment = $view->getFactory();

        $path = null;

        if (!str_contains($view->getName(), '::')) {

            // If there is no namespace the default
            // hint / location is streams.
            $path = "streams/{$view->getName()}";

        } else {

            list($namespace, $path) = explode('::', $view->getName());

            if (str_contains($namespace, '.')) {

                list($type, $slug) = explode('.', $namespace);

            } else {

                // If the namespace is a shortcut for an "active" addon
                // then resolve it through the IoC registered addon.
                $addon = app("streams.{$namespace}.collection")->active();

                $type = $addon->getType();
                $slug = $addon->getSlug();

            }

            $path = "{$type}/{$slug}/{$path}";

        }

        $path = "theme::overload/{$path}";

        if ($path and $environment->exists($path)) {

            $view->setPath($environment->getFinder()->find($path));

        }

        return $view;
    }

    protected function overloadMobileView(View $view)
    {
        return $view;
    }
}
