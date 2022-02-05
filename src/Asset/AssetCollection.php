<?php

namespace Streams\Core\Asset;

use Illuminate\Support\Collection;
use Streams\Core\Support\Facades\Assets;

/**
 * A collection of assets in the pipeline.
 */
class AssetCollection extends Collection
{

    private array $loaded = [];

    public function add($asset): void
    {
        $this->put($asset, Assets::realPath($asset));
    }

    public function load(string $name): AssetCollection
    {
        if (isset($this->loaded[$name])) {
            return $this;
        }

        $resolved = (array) Assets::resolve($name);

        foreach ($resolved as $asset) {

            $this->loaded[$name] = $name;

            $this->put($asset, $asset);
        }

        return $this;
    }

    public function resolved(): AssetCollection
    {
        return $this->map(function ($asset) {
            return Assets::resolve($asset);
        });
    }

    public function urls(array $attributes = [], $secure = null): AssetCollection
    {
        return $this->resolved()->map(function ($asset) use ($attributes, $secure) {
            return Assets::url($asset, $attributes, $secure);
        });
    }

    public function tags(array $attributes = []): AssetCollection
    {
        return $this->resolved()->map(function ($asset) use ($attributes) {
            return Assets::tag($asset, $attributes);
        });
    }

    public function scripts(array $attributes = []): AssetCollection
    {
        return $this->resolved()->map(function ($asset) use ($attributes) {
            return Assets::script($asset, $attributes);
        });
    }

    public function styles(array $attributes = []): AssetCollection
    {
        return $this->resolved()->map(function ($asset) use ($attributes) {
            return Assets::style($asset, $attributes);
        });
    }

    public function inlines(): AssetCollection
    {
        return $this->resolved()->map(function ($asset) {
            return Assets::inline($asset);
        });
    }

    public function content(): AssetCollection
    {
        return $this->resolved()->map(function ($asset) {
            return Assets::contents($asset);
        });
    }

    public function __toString(): string
    {
        return implode("\n", $this->items);
    }
}
