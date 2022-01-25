<?php

namespace Streams\Core\Addon;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Streams\Core\Support\Traits\HasMemory;

/**
 * This class is used to register and access addons.
 */
class AddonManager
{
    use HasMemory;

    protected Collection $collection;

    public function __construct()
    {
        $this->collection = new Collection;
    }

    public function load(string $path): Addon
    {
        $path = rtrim($path, '/\\');

        $composer = json_decode(file_get_contents($path . '/composer.json'), true);

        $addon = [
            'name' => $composer['name'],
            'path' => $path,
            'composer' => $composer,
        ];

        return $this->register($addon);
    }

    public function register(array $addon): Addon
    {
        $addon = new Addon($addon);

        App::instance('streams.addons.' . str_replace('/', '.', $addon->name), $addon);

        $this->collection->put($addon->name, $addon);

        return $addon;
    }

    public function make(string $name): Addon
    {
        return App::make('streams.addons.' . str_replace('/', '.', $name));
    }

    public function collection(): Collection
    {
        return $this->collection;
    }
}
