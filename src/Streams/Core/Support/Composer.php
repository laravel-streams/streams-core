<?php namespace Streams\Core\Support;

class Composer
{
    /**
     * Compose the view before rendering.
     *
     * @param $view
     * @return mixed
     */
    public function compose($view)
    {
        $view = $this->overloadView($view);

        return $view;
    }

    /**
     * Overload the view path.
     *
     * @param $view
     * @return mixed
     */
    public function overloadView($view)
    {
        // If this is a theme view just return as is.
        if (starts_with('theme::', $view->getName())) {
            return $view;
        }

        $environment = $view->getFactory();
        $themeView   = null;

        if (!str_contains($view->getName(), '::')) {

            $themeView = "{$view->getName()}";

        } else {

            $segments          = explode('::', $view->getName());
            $namespaceSegments = explode('.', $segments[0]);

            $viewPath = $segments[1];

            if (count($namespaceSegments) == 2) {

                $addonType = $namespaceSegments[0];
                $addonSlug = $namespaceSegments[1];
                $themeView = "theme::app/{$addonType}/{$addonSlug}/{$viewPath}";

            } else {

                $namespace = $segments[0];
                $viewPath  = $segments[1];

                $themeView = "theme::app/{$namespace}/{$viewPath}";

            }
        }

        if ($themeView and $environment->exists($themeView)) {
            $view->setPath($environment->getFinder()->find($themeView));
        }

        return $view;
    }
}
