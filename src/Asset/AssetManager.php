<?php

namespace Streams\Core\Asset;

use Illuminate\Support\Arr;
use Collective\Html\HtmlBuilder;
use Illuminate\Support\Facades\URL;
use Illuminate\Filesystem\Filesystem;

/**
 * The asset manager is a base named-asset pipeline utility:
 *
 * ```php
 * Assets::load('scripts', 'your/script.js');
 * ```
 * 
 * ```blade
 * {!! Assets::collection('scripts')->output() !!}
 * ```
 */
class AssetManager
{

    protected array $collections = [];

    protected array $resolved = [];

    protected HtmlBuilder $html;

    protected Filesystem $files;

    protected AssetPaths $paths;

    protected AssetRegistry $registry;

    public function __construct(
        AssetRegistry $registry,
        Filesystem $files,
        AssetPaths $paths,
        HtmlBuilder $html
    ) {
        $this->html     = $html;
        $this->files    = $files;
        $this->paths    = $paths;
        $this->registry = $registry;
    }

    public function collection(string $name): AssetCollection
    {
        if (!$collection = Arr::get($this->collections, $name)) {
            $this->collections[$name] = $collection = new AssetCollection();
        }

        return $collection;
    }

    /**
     * @param string $collection
     * @param string|array $assets
     * @return void
     */
    public function add(string $collection, $assets): void
    {
        $collection = $this->collection($collection);

        foreach ((array) $assets as $key => $asset) {

            $key = is_numeric($key) ? $asset : $key;

            $collection->put($key, $asset);
        }
    }

    public function load(string $collection, string $asset): void
    {
        $this->collection($collection)->load($asset);
    }

    /**
     * Register assets by name.
     *
     * @param string $name
     * @param string|array|null $assets
     * @return $this
     */
    public function register(string $name, $assets = null)
    {
        $assets = $assets ?: $name;

        $this->registry->register($name, $assets);

        return $this;
    }

    public function inline(string $asset): string
    {
        $asset = $this->resolve($asset);

        if (!filter_var($asset, FILTER_VALIDATE_URL)) {
            $asset = public_path(ltrim($asset, '/\\'));
        }

        $contents = file_get_contents($asset);

        if (pathinfo($asset, PATHINFO_EXTENSION) == 'js') {
            return $this->script(null, [], $contents);
        }

        if (pathinfo($asset, PATHINFO_EXTENSION) == 'css') {
            return $this->style(null, [], $contents);
        }
    }

    public function contents(string $asset): string
    {
        $asset = $this->resolve($asset);

        if (!filter_var($asset, FILTER_VALIDATE_URL)) {
            $asset = public_path(ltrim($asset, '/\\'));
        }

        return file_get_contents($asset);
    }

    public function url(
        string $asset,
        array $parameters = [],
        bool $secure = null
    ): string {
        return URL::to($this->resolve($asset), $parameters, $secure);
    }

    public function tag(string $asset, array $attributes = []): string
    {
        $asset = $this->resolve($asset);

        if (pathinfo($asset, PATHINFO_EXTENSION) == 'js') {
            return $this->script($asset, $attributes);
        } else {
            return $this->style($asset, $attributes);
        }
    }

    public function script(
        string $asset = null,
        array $attributes = [],
        string $content = null
    ): string {
        
        if (!$content) {
            $attributes['src'] = $this->resolve($asset);
        }

        if (
            isset($attributes['src'])
            && $attributes['src'] === basename($attributes['src'])
        ) {
            $attributes['src'] = '/' . $attributes['src'];
        }

        return '<script' . $this->html->attributes($attributes) . '>' . $content . '</script>';
    }

    public function style(string $asset = null, array $attributes = [], $content = null): string
    {
        $defaults = ['media' => 'all', 'type' => 'text/css', 'rel' => 'stylesheet'];

        $attributes = $attributes + $defaults;

        if ($content) {
            return '<style' . $this->html->attributes($attributes) . '>' . $content . '</style>';
        }

        if (!$content) {
            $attributes['href'] = $this->resolve($asset);
        }

        if (
            isset($attributes['href'])
            && $attributes['href'] === basename($attributes['href'])
        ) {
            $attributes['href'] = '/' . $attributes['href'];
        }

        return '<link' . $this->html->attributes($attributes) . '/>';
    }

    /**
     * @param string $asset
     * @return string|null
     */
    public function resolve(string $asset)
    {
        if (isset($this->resolved[$asset])) {
            return $this->resolved[$asset];
        }

        if (filter_var($asset, FILTER_VALIDATE_URL)) {
            return $asset;
        }

        $resolved = $this->registry->resolve($asset);

        if (is_array($resolved)) {
            return $this->resolved[$asset] = array_map(function ($asset) {
                return $this->realPath($asset);
            }, $resolved);
        }

        return $this->resolved[$asset] = $this->realPath($resolved);
    }

    public function addPath(string $namespace, string $path)
    {
        $this->paths->addPath($namespace, $path);

        return $this;
    }

    public function realPath(string $asset)
    {
        return $this->paths->real($asset);
    }

    public function __toString(): string
    {
        return '';
    }
}
