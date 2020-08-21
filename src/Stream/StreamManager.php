<?php

namespace Anomaly\Streams\Platform\Stream;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Anomaly\Streams\Platform\Stream\Stream;
use Anomaly\Streams\Platform\Support\Traits\HasMemory;
use Anomaly\Streams\Platform\Repository\Contract\RepositoryInterface;
use Illuminate\Support\Traits\Macroable;

/**
 * Class StreamManager
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class StreamManager
{

    use HasMemory;
    use Macroable;

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
        return App::make('streams.instances.' . $stream);
    }

    /**
     * Build a stream instance.
     *
     * @param array $stream
     * @return Stream
     */
    public function build(array $stream)
    {
        $stream = StreamBuilder::build($stream);

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
     * @return CriteriaInterface
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
