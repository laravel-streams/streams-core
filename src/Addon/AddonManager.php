<?php

namespace Streams\Core\Addon;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Streams\Core\Support\Traits\HasMemory;

/**
 * This class is used to register and access addons.
 */
class AddonManager
{
    use HasMemory;

    public function __construct(protected Collection $collection) {}

    /**
     * Load all addons in a directory.
     *
     * @return array<Addon>
     */
    public function loadDirectory(string $directory): array
    {
        $directory = rtrim($directory, '/\\');

        $addons = [];

        if (! is_dir($directory)) {
            return $addons;
        }

        foreach (scandir($directory) as $entry) {

            if ($entry === '.' || $entry === '..') {
                continue;
            }

            $path = $directory.DIRECTORY_SEPARATOR.$entry;

            if (is_dir($path) && file_exists($path.'/composer.json')) {
                $addons[] = $this->load($path);
            }
        }

        return $addons;
    }

    public function load(string $path): Addon
    {
        $path = rtrim($path, '/\\');

        $composer = json_decode(file_get_contents($path.'/composer.json'), true);

        try {
            $addon = [
                'name' => $composer['name'],
                'path' => $path,
                'composer' => $composer,
            ];
        } catch (\Exception $e) {
            throw new \Exception("Invalid addon at [{$path}].");
        }

        return $this->register($addon);
    }

    /**
     * A package is discoverable when its Composer type is streams-addon
     * or the documented extra.streams.addon flag is set.
     *
     * @param  array<string, mixed>  $package
     */
    public function isAddonPackage(array $package): bool
    {
        if (Arr::get($package, 'type') === 'streams-addon') {
            return true;
        }

        return (bool) Arr::get($package, 'extra.streams.addon');
    }

    /**
     * Register an addon from an attribute array, or from the documented
     * name and paths pair: Addons::register('my-addon', $paths).
     *
     * @param  array<string, mixed>|string  $addon
     * @param  array<string, mixed>|string|null  $paths
     */
    public function register(array|string $addon, array|string|null $paths = null): Addon
    {
        if (is_string($addon)) {
            $addon = $this->attributesFromNameAndPaths($addon, $paths);
        }

        $addon = new Addon($addon);

        App::instance('streams.addons.'.str_replace('/', '.', $addon->name), $addon);

        $this->collection->put($addon->name, $addon);

        return $addon;
    }

    public function make(string $name): Addon
    {
        return App::make('streams.addons.'.str_replace('/', '.', $name));
    }

    public function collection(): Collection
    {
        return $this->collection;
    }

    public function providing($service)
    {
        return $this->collection->filter(function ($addon) use ($service) {
            return $addon->provides($service);
        });
    }

    /**
     * @param  array<string, mixed>|string|null  $paths
     * @return array<string, mixed>
     */
    protected function attributesFromNameAndPaths(string $name, array|string|null $paths): array
    {
        if (is_string($paths)) {
            $attributes = [
                'path' => $paths,
                'paths' => [$paths],
            ];
        } elseif (is_array($paths)) {
            $attributes = $paths;
            $attributes['paths'] = $paths['paths'] ?? $paths;
        } else {
            $attributes = [
                'paths' => [],
            ];
        }

        $attributes['name'] = $name;
        $attributes['composer'] ??= [];

        return $attributes;
    }
}
