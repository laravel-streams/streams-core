<?php

namespace Anomaly\Streams\Platform\Stream;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Anomaly\Streams\Platform\Stream\Stream;
use Anomaly\Streams\Platform\Support\Traits\HasMemory;
use Anomaly\Streams\Platform\Repository\Contract\RepositoryInterface;

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
        return $this->once(md5(json_encode($stream)), function () use ($stream) {

            $stream = StreamBuilder::build($stream);

            App::singleton('streams.instances.' . $stream->handle, $stream);

            return $stream;
        });
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

        $this->register($stream);
    }

    /**
     * Register a stream instance.
     *
     * @param array $stream
     * @return Stream
     */
    public function register(array $stream)
    {
        /**
         * Route the Stream.
         * @todo Hmmm.. is this appropriate?
         */
        if ($routes = Arr::get($stream, 'route')) {
            foreach ($routes as $key => $route) {
                Route::any($route, [
                    'stream' => $stream['handle'],
                    'as' => 'streams.' . $stream['handle'] . '.' . $key,
                    'uses' => Arr::get($stream, 'uses', EntryController::class . '@render'),
                ]);
            }
        }

        App::singleton('streams.instances.' . $stream['handle'], function () use ($stream) {
            return StreamBuilder::build($stream);
        });
    }

    /**
     * Return an entry criteria.
     * 
     * @return CriteriaInterface
     */
    function entries($stream)
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
    function repository($stream)
    {
        return $this
            ->make($stream)
            ->repository();
    }
}
