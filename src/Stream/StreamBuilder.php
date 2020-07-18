<?php

namespace Anomaly\Streams\Platform\Stream;

use Illuminate\Support\Arr;
use Anomaly\Streams\Platform\Field\FieldBuilder;
use Anomaly\Streams\Platform\Field\FieldFactory;

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
        $stream = StreamFactory::make($stream);

        $fields = FieldBuilder::build($fields);
        $fields = FieldFactory::make($fields);

        $stream->fields = $fields;

        $stream->fire('built', compact($stream));

        return $stream;
    }
}
