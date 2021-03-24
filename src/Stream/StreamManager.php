<?php

namespace Streams\Core\Stream;

use Exception;
use Illuminate\Support\Arr;
use Streams\Core\Stream\Stream;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Streams\Core\Criteria\Criteria;
use Streams\Core\Stream\StreamBuilder;
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
     * @param $stream
     * @return Stream
     */
    public function build($stream)
    {

        /**
         * If the stream is a string
         * then treat it like a file.
         */
        if (is_string($stream)) {

            $stream = json_decode(file_get_contents($file = $stream), true);

            $handle = basename($file, '.json');

            Arr::set($stream, 'handle', Arr::get($stream, 'handle', $handle));
        }

        $stream = Arr::undot($stream);

        $workflow = (new StreamBuilder)
            ->passThrough($this);

        $workflow->stream = $stream;

        $workflow->passThrough($this)->process([
            'workflow' => $workflow
        ]);

        $stream = $workflow->stream;

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

        return $stream;
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
}
