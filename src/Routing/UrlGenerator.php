<?php namespace Anomaly\Streams\Platform\Routing;

use Anomaly\Streams\Platform\Support\Presenter;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Routing\RouteCollection;
use Illuminate\Support\Str;
use StringTemplate\Engine;

/**
 * Class UrlGenerator
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Routing
 */
class UrlGenerator extends \Illuminate\Routing\UrlGenerator
{

    /**
     * The parser engine.
     *
     * @var Engine
     */
    protected $parser;

    /**
     * Create a new UrlGenerator instance.
     *
     * @param RouteCollection $routes
     * @param Request         $request
     */
    public function __construct(RouteCollection $routes, Request $request)
    {
        parent::__construct(app('router')->getRoutes(), $request);

        $this->parser = app(Engine::class);

        if (defined('LOCALE')) {
            $this->forceRootUrl($this->getRootUrl($this->getScheme(null)) . '/' . LOCALE);
        }
    }

    /**
     * Generate an absolute URL to the given asset.
     *
     * @param            $path
     * @param null       $locale
     * @param  mixed     $extra
     * @param  bool|null $secure
     * @return string
     */
    public function locale($path, $locale = null, $extra = [], $secure = null)
    {
        if ($locale == config('streams::locales.default')) {
            $locale = null;
        }

        return $this->asset($locale ? $locale . '/' . $path : $path, $extra, $secure);
    }

    /**
     * Generate an absolute URL to the given asset.
     *
     * @param  string    $asset
     * @param  mixed     $extra
     * @param  bool|null $secure
     * @return string
     */
    public function asset($asset, $extra = [], $secure = null)
    {
        // First we will check if the URL is already a valid URL. If it is we will not
        // try to generate a new one but will simply return the URL as is, which is
        // convenient since developers do not always have to check if it's valid.
        if ($this->isValidUrl($asset)) {
            return $asset;
        }

        $scheme = $this->getScheme($secure);

        $extra = $this->formatParameters($extra);

        $tail = implode('/', array_map('rawurlencode', (array)$extra));

        // Once we have the scheme we will compile the "tail" by collapsing the values
        // into a single string delimited by slashes. This just makes it convenient
        // for passing the array of parameters to this URL as a list of segments.
        $root = $this->getRootUrl($scheme);

        if (defined('LOCALE') && ends_with($root, $search = '/' . LOCALE)) {
            $root = substr_replace($root, '', strrpos($root, $search), strlen($search));
        }

        if (($queryPosition = strpos($asset, '?')) !== false) {
            $query = mb_substr($asset, $queryPosition);
            $asset = mb_substr($asset, 0, $queryPosition);
        } else {
            $query = '';
        }

        return $this->trimUrl($root, $asset, $tail) . $query;
    }

    /**
     * Make a route path.
     *
     * @param       $name
     * @param       $entry
     * @param array $parameters
     * @return mixed|null|string
     */
    public function make($name, $entry, array $parameters = [])
    {
        if (!$route = $this->routes->getByName($name)) {
            return null;
        }

        if ($entry instanceof Presenter) {
            $entry = $entry->getObject();
        }

        if ($entry instanceof Arrayable) {
            $entry = $entry->toArray();
        }

        return $this->addQueryString($this->parser->render($route->uri(), $entry), $parameters);
    }
}
