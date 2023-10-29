<?php

namespace Streams\Core\Asset;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Collective\Html\HtmlBuilder;
use Illuminate\Support\Facades\URL;
use Illuminate\Filesystem\Filesystem;

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

    public function add(string $collection, array|string $assets = null): void
    {
        $collection = $this->collection($collection);

        foreach ((array) $assets as $key => $asset) {

            $key = is_numeric($key) ? $asset : $key;

            $collection->put($key, $asset);
        }
    }

    public function load(string $collection, string $asset)
    {
        $this->collection($collection)->load($asset);

        return $this;
    }

    public function register(string $name, $assets = null)
    {
        $assets = $assets ?: $name;

        $this->registry->register(ltrim($name, '/'), $assets);

        return $this;
    }

    public function inline(string $asset): string
    {
        $asset = $this->resolve($asset);

        if (!filter_var($asset, FILTER_VALIDATE_URL)) {
            $asset = public_path(ltrim($asset, '/\\'));
        }

        if (pathinfo($asset, PATHINFO_EXTENSION) == 'js') {
            return $this->script(null, [], file_get_contents($asset));
        }

        if (pathinfo($asset, PATHINFO_EXTENSION) == 'css') {
            return $this->style(null, [], file_get_contents($asset));
        }

        return file_get_contents($asset);
    }

    public function contents(string $asset): string
    {
        $asset = $this->resolve($asset);

        if (!Str::startsWith($asset, [base_path(), 'http://', 'https://'])) {
            $asset = base_path(ltrim($asset, '/\\'));
        }

        return file_get_contents($asset);
    }

    public function url(
        string $asset,
        array $parameters = [],
        bool $secure = null
    ): string {
        return URL::to(str_replace([
            public_path(),
            base_path(),
        ], '', $this->resolve($asset)), $parameters, $secure);
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

        return '<link' . $this->html->attributes($attributes) . '/>';
    }

    public function img(string $src = null, array $attributes = []): string
    {
        $defaults = [];

        $attributes = $attributes + $defaults;

        if (!isset($attributes['src'])) {
            $attributes['src'] = $this->resolve($src);
        }

        return '<img' . $this->html->attributes($attributes) . '/>';
    }

    public function svg(string $asset = null, array $attributes = [], $content = null): string
    {
        $output = $content ?: $this->inline($asset);

        foreach ($attributes as $attribute => $value) {

            // Add or replace the attribute value.
            if (preg_match("/{$attribute}=\".*?\"/", $output)) {
                $output = preg_replace("/{$attribute}=\".*?\"/", "{$attribute}=\"{$value}\"", $output);
            } else {
                $output = str_replace('<svg', "<svg {$attribute}=\"{$value}\"", $output);
            }
        }

        return $output;
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
        $real = $this->paths->real($asset);

        if (!Str::startsWith($real, [base_path(), 'http://', 'https://'])) {
            $real = '/' . ltrim($real, '/');
        }

        return $real;
    }

    public function __toString(): string
    {
        return '';
    }
}
