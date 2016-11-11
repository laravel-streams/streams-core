<?php namespace Anomaly\Streams\Platform\Entry;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Routing\UrlGenerator;
use Anomaly\Streams\Platform\Support\Locator;
use Anomaly\Streams\Platform\Support\Str;
use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class EntryRouter
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class EntryRouter
{

    use DispatchesJobs;

    /**
     * The string utility.
     *
     * @var Str
     */
    protected $str;

    /**
     * The URL generator;
     *
     * @var UrlGenerator
     */
    protected $url;

    /**
     * The entry instance.
     *
     * @var EntryInterface
     */
    protected $entry;

    /**
     * The locator utility.
     *
     * @var Locator
     */
    protected $locator;

    /**
     * The service container.
     *
     * @var Container
     */
    protected $container;

    /**
     * Create a new EntryRouter instance.
     *
     * @param UrlGenerator   $url
     * @param Str            $str
     * @param EntryInterface $entry
     * @param Locator        $locator
     * @param Container      $container
     */
    public function __construct(
        UrlGenerator $url,
        Str $str,
        EntryInterface $entry,
        Locator $locator,
        Container $container
    ) {
        $this->str       = $str;
        $this->url       = $url;
        $this->entry     = $entry;
        $this->locator   = $locator;
        $this->container = $container;
    }

    /**
     * Make a route.
     *
     * @param                    $route
     * @param  array             $parameters
     * @return mixed|null|string
     */
    public function make($route, array $parameters = [])
    {
        if (method_exists($this, $method = $this->str->camel(str_replace('.', '_', $route)))) {

            $parameters['parameters'] = $parameters;

            return $this->container->call([$this, $method], $parameters);
        }

        if (!str_contains($route, '.') && $stream = $this->entry->getStreamSlug()) {
            $route = "{$stream}.{$route}";
        }

        if (!str_contains($route, '::') && $namespace = $this->locator->locate($this->entry)) {
            $route = "{$namespace}::{$route}";
        }

        return $this->url->make($route, $this->entry, $parameters);
    }
}
