<?php

namespace Streams\Core\Stream;

use Exception;
use Illuminate\Support\Arr;
use Streams\Core\Stream\Stream;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Streams\Core\Criteria\Criteria;
use Illuminate\Support\Facades\Route;
use Streams\Core\Support\Traits\HasMemory;
use Streams\Core\Support\Traits\Prototype;
use Streams\Core\Support\Traits\FiresCallbacks;
use Streams\Core\Repository\Contract\RepositoryInterface;
use Illuminate\Contracts\Container\BindingResolutionException;

class StreamManager
{

    use HasMemory;
    use Prototype;
    use FiresCallbacks;

    /**
     * The streams collection.
     *
     * @var Collection
     */
    protected $collection;

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->collection = new Collection;
    }

    /**
     * Make a stream instance.
     *
     * @param string $stream
     * @return Stream
     */
    public function make($stream)
    {
        try {

            if (!is_array($stream)) {
                return App::make('streams.instances.' . $stream);
            }

            if (!$this->has($stream['handle'])) {
                return $this->register($stream);
            }

            return App::make('streams.instances.' . $stream['handle']);
        } catch (BindingResolutionException $e) {
            throw new Exception("Stream [{$stream}] does not exist.");
        }
    }

    public function merge($target, array $merge)
    {
        $target = $this->make($target);

        $target->loadPrototypeAttributes($merge);

        App::make('streams.instances.' . $target->handle);

        return $target;
    }

    /**
     * Check if a given
     * stream exists.
     *
     * @param string $handle
     * @return bool
     */
    public function has($handle)
    {
        return App::has('streams.instances.' . $handle);
    }

    /**
     * Build a stream instance.
     *
     * @param array $attributes
     * @return Stream
     */
    public function build(array $attributes)
    {
        $stream = $attributes = Arr::undot($attributes);

        $stream = new Stream($attributes);

        $stream->fire('built', ['stream' => $stream]);

        return $stream;
    }

    /**
     * Load a stream instance.
     *
     * @param $file
     * @return Stream
     */
    public function load($file)
    {
        $stream = json_decode(file_get_contents($file), true);

        $handle = basename($file, '.json');

        Arr::set($stream, 'handle', Arr::get($stream, 'handle', $handle));

        return $this->register($stream);
    }

    /**
     * Register a stream instance.
     *
     * @param array $stream
     * @return Stream
     */
    public function register(array $stream)
    {
        $stream = $this->build($stream);
        
        App::instance('streams.instances.' . $stream->handle, $stream);

        $this->collection->put($stream->handle, $stream);

        $this->routeStream($stream);

        return $stream;
    }

    public function overload(array $stream)
    {
        $instance = $this->make($stream);

        foreach ($stream as $key => $value) {
            $instance->setPrototypeAttributeValue($key, $value);
        }

        App::instance('streams.instances.' . $instance->handle, $instance);
    }

    /**
     * Return an entry criteria.
     * 
     * @return Criteria
     */
    public function entries($stream)
    {
        return $this
            ->make($stream)
            ->entries();
    }

    /**
     * Return an entry repository.
     * 
     * @return RepositoryInterface
     */
    public function repository($stream)
    {
        return $this
            ->make($stream)
            ->repository();
    }

    /**
     * Return the Streams collection.
     * 
     * @return Collection
     */
    public function collection()
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
