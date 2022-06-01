<?php

namespace Streams\Core\Stream;

use Illuminate\Support\Arr;
use Streams\Core\Stream\Stream;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Streams\Core\Criteria\Criteria;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Traits\Macroable;
use Streams\Core\Support\Traits\HasMemory;
use Streams\Core\Support\Traits\FiresCallbacks;
use Streams\Core\Repository\Contract\RepositoryInterface;
use Illuminate\Contracts\Container\BindingResolutionException;

class StreamManager
{

    use HasMemory;
    use Macroable;
    use FiresCallbacks;

    protected Collection $collection;

    public function __construct()
    {
        $this->collection = new Collection;
    }

    public function build(array $attributes): Stream
    {
        $attributes = Arr::undot($attributes);

        $attributes['id'] = Arr::get($attributes, 'id', md5(json_encode($attributes)));

        $stream = new Stream($attributes);

        $stream->fire('built', ['stream' => $stream]);

        return $stream;
    }

    public function register(array $stream): Stream
    {
        $stream = $this->build($stream);

        App::instance('streams.instances.' . $stream->id, $stream);

        $this->collection->put($stream->id, $stream);

        $this->route($stream);

        return $stream;
    }

    public function exists(string $id): bool
    {
        return App::has('streams.instances.' . $id);
    }

    public function make(string $id): Stream
    {
        try {
            return App::make('streams.instances.' . $id);
        } catch (BindingResolutionException $e) {
            throw new \Exception("Stream [{$id}] is not registered.");
        }
    }

    public function extend(string $id, array $stream): Stream
    {
        $target = $this->overload($id, $stream);

        $target::resetMemory();

        App::instance('streams.instances.' . $target->id, $target);

        $this->collection->put($target->id, $target);

        $this->route($target);

        return $target;
    }

    public function overload(string $id, array $attributes): Stream
    {
        $original = $this->make($id)->getOriginalPrototypeAttributes();

        $attributes = array_replace_recursive($original, $attributes);
        
        return $this->build($attributes);
    }

    public function load(string $file): Stream
    {
        $stream = json_decode(file_get_contents($file), true);

        $id = basename($file, '.json');

        Arr::set($stream, 'id', Arr::get($stream, 'id', $id));

        return $this->register($stream);
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

    public function schema(string $id): StreamSchema
    {
        return $this
            ->make($id)
            ->schema();
    }

    public function collection(): Collection
    {
        return $this->collection;
    }

    public function route(Stream $stream): void
    {
        if (!App::routesAreCached()) {

            foreach ($stream->routes ?: [] as $key => $route) {

                if (is_string($route)) {
                    $route = [
                        'uri' => $route,
                    ];
                }

                $key = Arr::get($route, 'handle', $key);

                /**
                 * Automatically bind if not bound.
                 */
                if (!isset($route['stream'])) {
                    $route['stream'] = $stream->id;
                }

                /**
                 * Automatically name if not named.
                 */
                $route['as'] = Arr::get($route, 'as', $stream->id . '.' . $key);

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
                Route::streams(Arr::pull($route, 'uri'), $route);
            }
        }
    }
}
