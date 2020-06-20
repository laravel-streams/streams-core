<?php

use Illuminate\Support\Str;
use Collective\Html\FormFacade;
use Collective\Html\HtmlFacade;
use Illuminate\Support\Collection;
use Anomaly\Streams\Platform\Image\ImageManager;
use Anomaly\Streams\Platform\Asset\Facades\Assets;
use Anomaly\Streams\Platform\Support\Facades\Streams;
use Anomaly\Streams\Platform\Criteria\Contract\CriteriaInterface;


if (!function_exists('assets')) {

    /**
     * Add an asset to a collection or instance.
     *
     * @param null $collection
     * @param null $asset
     * @return \Anomaly\Streams\Platform\Asset\Asset
     */
    function assets($collection = null, $asset = null)
    {
        if ($collection && $asset) {
            return Assets::collection($collection)->add($asset);
        }

        if ($collection) {
            return Assets::collection($collection);
        }

        return app('assets');
    }
}

if (!function_exists('img')) {

    /**
     * Return an image instance.
     *
     * @param mixed $source
     * @return \Anomaly\Streams\Platform\Image\ImageManager
     */
    function img($source = null)
    {
        if (!$source) {
            return app(ImageManager::class);
        }

        return app(ImageManager::class)->make($source);
    }
}

if (!function_exists('favicons')) {

    /**
     * Return favicons from a single source.
     *
     * @param $source
     * @return \Illuminate\View\View
     */
    function favicons($source)
    {
        return view('streams::partials.favicons', compact('source'));
    }
}

if (!function_exists('constants')) {

    /**
     * Return required JS constants.
     * 
     * @todo this should probably be moved into core/streams-platform instead of streams::
     * @return \Illuminate\View\View
     */
    function constants()
    {
        return view('streams::partials.constants');
    }
}

if (!function_exists('stream')) {

    /**
     * Return a Stream instance.
     * 
     * @param $stream
     * @return Stream
     */
    function stream($stream)
    {
        return Streams::make($stream);
    }
}

if (!function_exists('entries')) {

    /**
     * Return a collection of entries.
     * 
     * @return CriteriaInterface
     */
    function entries($stream)
    {
        return stream($stream)->repository()->newCriteria();
    }
}

if (!function_exists('html_link')) {

    /**
     * Generate a HTML link.
     *
     * @param string $url
     * @param string $title
     * @param array  $attributes
     * @param bool   $secure
     * @param bool   $escape
     *
     * @return \Illuminate\Support\HtmlString
     */
    function html_link($url, $title = null, $attributes = [], $secure = null, $escape = true)
    {
        return HtmlFacade::link($url, $title, $attributes, $secure, $escape);
    }
}

if (!function_exists('addon_map')) {

    /**
     * Return the variable map
     * for an addon namespace.
     *
     * @param string $namespace
     * @param bool $verify
     *
     * @return array
     */
    function addon_map($namespace, $verify = true)
    {
        [$vendor, $type, $slug] = array_map(
            function ($value) {
                return Str::slug(strtolower($value), '_');
            },
            explode('.', $namespace)
        );

        if ($verify && preg_match('/^\w+\.[a-zA-Z_]+\.\w+\z/u', $namespace) !== 1) {
            throw new \Exception('Addon identifiers must be snake case and follow the following pattern: {vendor}.{type}.{slug}');
        }

        return [$vendor, $type, $slug];
    }
}

if (!function_exists('translate')) {

    /**
     * Return a recursively translated target.
     *
     * @param mixed $target
     * @return mixed
     */
    function translate($target)
    {
        if (is_string($target) && strpos($target, '::')) {

            if (!trans()->has($target)) {
                return $target;
            }

            return trans($target);
        }

        if (is_array($target)) {
            foreach ($target as &$item) {
                $item = translate($item);
            }
        }

        if ($target instanceof Collection) {
            foreach ($target as &$item) {
                $item = translate($item);
            }
        }

        return $target;
    }
}

if (!function_exists('resolver')) {

    /**
     * Resolve the target.
     *
     * @param $target
     * @param array $arguments
     * @param array $options
     * @return mixed
     */
    function resolver($target, array $arguments = [], array $options = [])
    {
        return \Anomaly\Streams\Platform\Support\Facades\Resolver::resolve($target, $arguments, $options);
    }
}

if (!function_exists('evaluate')) {

    /**
     * Resolve the target.
     *
     * @param $target
     * @param array $arguments
     * @return mixed
     */
    function evaluate($target, array $arguments = [])
    {
        return \Anomaly\Streams\Platform\Support\Facades\Evaluator::evaluate($target, $arguments);
    }
}

if (!function_exists('icon')) {

    /**
     * Return an icon.
     *
     * @param $icon
     * @return string
     */
    function icon($icon)
    {
        return '<i class="' . app(\Anomaly\Streams\Platform\Ui\Icon\IconRegistry::class)->get($icon) . '"></i>';
    }
}

if (!function_exists('addon')) {

    /**
     * Return an addon instance.
     *
     * @param  string $identifier
     * @return \Anomaly\Streams\Platform\Addon\Addon|null
     */
    function addon($identifier)
    {
        try {
            app($identifier);
        } catch (\Exception $exception) {
            return null;
        }
    }
}
