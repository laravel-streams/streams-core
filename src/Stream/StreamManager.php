<?php

namespace Anomaly\Streams\Platform\Stream;

use Illuminate\Support\Facades\App;
use Anomaly\Streams\Platform\Stream\StreamRegistry;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Class StreamManager
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class StreamManager
{

    /**
     * The Stream registry.
     *
     * @var array
     */
    protected $registry;

    /**
     * Create a new class instance.
     *
     * @param StreamRegistry $registry
     */
    public function __construct(StreamRegistry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * Make a stream instance.
     *
     * @param string $stream
     * @return StreamInterface
     */
    public function make($stream)
    {
        return App::make('streams::' . $stream);
    }
}
