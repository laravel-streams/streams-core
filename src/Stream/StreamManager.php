<?php

namespace Streams\Core\Stream;

use Exception;
use Illuminate\Support\Arr;
use Streams\Core\Stream\Stream;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Streams\Core\Criteria\Criteria;
use Streams\Core\Entry\EntryFactory;
use Illuminate\Support\Facades\Route;
use Streams\Core\Support\Traits\HasMemory;
use Streams\Core\Support\Traits\FiresCallbacks;
use Streams\Core\Repository\Contract\RepositoryInterface;
use Illuminate\Contracts\Container\BindingResolutionException;

class StreamManager
{

    use HasMemory;
    use FiresCallbacks;

    protected Collection $collection;

    public function __construct()
    {
        $this->collection = new Collection;
    }

    public function make(string $id): Stream
    {
        try {
            return App::make('streams.instances.' . $id);
        } catch (BindingResolutionException $e) {
            throw new Exception("Stream [{$id}] does not exist.");
        }
    }

    public function merge($target, array $merge)
    {
        $target = $this->make($target);

        $target->loadPrototypeAttributes($merge);

        App::make('streams.instances.' . $target->handle);

        return $target;
    }

    public function has(string $id): bool
    {
        return App::has('streams.instances.' . $id);
    }

    public function build(array $attributes): Stream
    {
        $stream = $attributes = Arr::undot($attributes);

        $stream = new Stream($attributes);

        $stream->fire('built', ['stream' => $stream]);

        return $stream;
    }

    public function load(string $file): Stream
    {
        if (!file_exists($file)) {
            throw new \Exception("File [$file] does not exist.");
        }

        $stream = json_decode(file_get_contents($file), true);

        $handle = basename($file, '.json');

        Arr::set($stream, 'handle', Arr::get($stream, 'handle', $handle));

        return $this->register($stream);
    }

    public function register(array $stream): Stream
    {
        $stream = $this->build($stream);

        App::instance('streams.instances.' . $stream->id, $stream);

        $this->collection->put($stream->id, $stream);

        $this->routeStream($stream);

        return $stream;
    }

    public function overload(array $stream): void
    {
        $instance = $this->make($stream['id']);

        foreach ($stream as $key => $value) {
            $instance->{$key} = $value;
        }

        App::instance('streams.instances.' . $instance->id, $instance);
    }

    public function entries(string $id): Criteria
    {
        return $this
            ->make($id)
            ->entries();
    }

    public function repository(string $id): RepositoryInterface
    {
        return $this
            ->make($id)
            ->repository();
    }

    public function factory(string $id): EntryFactory
    {
        return $this
            ->make($id)
            ->factory();
    }

    public function collection(): Collection
    {
        return $this->collection;
    }

    /**
     * Register the routes for a stream.
     *
     * @param \Streams\Core\Stream\Stream $stream
     */
    protected function routeStream(Stream $stream)
    {

        /**
         * If not cached.
         */
        if (!App::routesAreCached()) {

            foreach ($stream->routes ?: [] as $key => $route) {

                if (is_string($route)) {
                    $route = [
                        'uri' => $route,
                    ];
                }

                /**
                 * Automatically bind if not bound.
                 */
                if (!isset($route['stream'])) {
                    $route['stream'] = $stream->handle;
                }

                /**
                 * Automatically name if not named.
                 */
                $route['as'] = Arr::get($route, 'as', 'streams::' . $stream->handle . '.' . $key);

                /**
                 * Automatically group if not grouped.
                 * @todo configure default
                 */
                $route['middleware'] = Arr::get($route, 'middleware', 'web');

                /**
                 * Defer if opted to.
                 */
                if (Arr::pull($route, 'defer')) {

                    App::booted(function () use ($route) {
                        Route::streams(Arr::get($route, 'uri'), $route);
                    });

                    continue;
                }

                /**
                 * Register the route.
                 */
                Route::streams(Arr::get($route, 'uri'), $route);
            }
        }
    }
}
