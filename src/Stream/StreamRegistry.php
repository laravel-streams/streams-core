<?php

namespace Anomaly\Streams\Platform\Stream;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Builder;
use Illuminate\Database\Schema\Blueprint;
use Anomaly\Streams\Platform\Entry\EntryModel;
use Anomaly\Streams\Platform\Field\FieldSchema;
use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Class StreamRegistry
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class StreamRegistry
{

    /**
     * The registered streams.
     *
     * @var array
     */
    protected $streams = [];

    /**
     * Register a stream model.
     *
     * @param string $stream
     * @param string $model
     * 
     * @return $this
     */
    public function register(string $stream, string $model)
    {
        $this->streams[$stream] = $model;

        app()->singleton($stream, function() use ($model) {
            return (new $model)->stream();
        });

        return $this;
    }

    /**
     * Get the streams.
     * 
     * @return array
     */
    public function getStreams()
    {
        return $this->streams;
    }
}
