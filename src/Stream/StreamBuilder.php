<?php

namespace Anomaly\Streams\Platform\Stream;

use Illuminate\Support\Arr;
use Anomaly\Streams\Platform\Field\FieldBuilder;
use Anomaly\Streams\Platform\Field\FieldFactory;
use Anomaly\Streams\Platform\Support\Facades\Streams;

/**
 * Class StreamBuilder
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class StreamBuilder
{

    /**
     * Build a stream.
     *
     * @param array $stream
     * @return Stream
     */
    public static function build(array $stream)
    {

        /**
         * Build our components and
         * configure the application.
         */
        $fields = Arr::pull($stream, 'fields', []);

        $stream = StreamInput::read($stream);

        /**
         * Merge extending Stream data.
         */
        if (isset($stream['extends'])) {
            
            $parent = Streams::make($stream['extends'])->toArray()['attributes'];

            $fields = array_merge(Arr::pull($parent, 'fields', []), $fields);

            $stream = array_merge_recursive_distinct($parent, $stream);
        }

        $stream = StreamFactory::make($stream);

        $fields = FieldBuilder::build($fields);
        $fields = FieldFactory::make($fields);

        $stream->fields = $fields;

        $stream->fire('built', compact($stream));

        return $stream;
    }
}
