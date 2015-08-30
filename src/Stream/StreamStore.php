<?php namespace Anomaly\Streams\Platform\Stream;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Class StreamStore
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Stream
 */
class StreamStore
{

    /**
     * The cached streams.
     *
     * @var array
     */
    protected $cache = [];

    /**
     * Put a stream into cache.
     *
     * @param                 $data
     * @param StreamInterface $stream
     */
    public function put($data, StreamInterface $stream)
    {
        $this->cache[md5(json_encode($data))] = $stream;
    }

    /**
     * Get a stream from cache.
     *
     * @param $data
     * @return null|StreamInterface
     */
    public function get($data)
    {
        if (isset($this->cache[md5(json_encode($data))])) {
            return $this->cache[md5(json_encode($data))];
        }

        return null;
    }
}
