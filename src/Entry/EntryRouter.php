<?php namespace Anomaly\Streams\Platform\Entry;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Routing\UrlGenerator;
use Anomaly\Streams\Platform\Support\Locator;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class EntryRouter
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\Streams\Platform\Entry
 */
class EntryRouter
{

    use DispatchesJobs;

    /**
     * The URL generator;
     *
     * @var UrlGenerator
     */
    protected $url;

    /**
     * The entry model.
     *
     * @var EntryInterface
     */
    protected $model;

    /**
     * The locator utility.
     *
     * @var Locator
     */
    protected $locator;

    /**
     * Create a new EntryRouter instance.
     *
     * @param UrlGenerator   $url
     * @param EntryInterface $model
     * @param Locator        $locator
     */
    public function __construct(UrlGenerator $url, EntryInterface $model, Locator $locator)
    {
        $this->url     = $url;
        $this->model   = $model;
        $this->locator = $locator;
    }

    /**
     * Make a route.
     *
     * @param       $route
     * @param array $parameters
     * @return mixed|null|string
     */
    public function make($route, array $parameters = [])
    {
        if (!str_contains($route, '.') && $namespace = $this->model->getStreamNamespace()) {
            $route = "{$namespace}.{$route}";
        }

        if (!str_contains($route, '::') && $namespace = $this->locator->locate($this->model)) {
            $route = "{$namespace}::{$route}";
        }

        return $this->url->make($route, $this->model, $parameters);
    }
}
