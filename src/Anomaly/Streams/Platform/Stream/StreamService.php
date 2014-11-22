<?php namespace Anomaly\Streams\Platform\Stream;

use Anomaly\Streams\Platform\Stream\Command\DeleteStreamCommand;
use Anomaly\Streams\Platform\Traits\CommandableTrait;

/**
 * Class StreamService
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Stream
 */
class StreamService
{

    use CommandableTrait;

    /**
     * Create a stream.
     *
     * @param array $stream
     * @return mixed
     */
    public function create(array $stream)
    {
        // Mandatory properties.
        $slug      = $stream['slug'];
        $name      = $stream['name'];
        $namespace = $stream['namespace'];

        // Optional properties
        $orderBy        = isset($stream['order_by']) ? $stream['order_by'] : 'id';
        $isHidden       = isset($stream['is_hidden']) ? $stream['is_hidden'] : false;
        $prefix         = isset($stream['prefix']) ? $stream['prefix'] : $namespace . '_';
        $titleColumn    = isset($stream['title_column']) ? $stream['title_column'] : 'id';
        $isTranslatable = isset($stream['is_translatable']) ? $stream['is_translatable'] : false;
        $viewOptions    = isset($stream['view_options']) ? $stream['view_options'] : ['id', 'created_at'];

        $description = isset($stream['description']) ? $stream['description'] : null;

        $data = compact(
            'slug',
            'name',
            'namespace',
            'orderBy',
            'isHidden',
            'prefix',
            'titleColumn',
            'isTranslatable',
            'viewOptions',
            'description'
        );

        return $this->execute('Anomaly\Streams\Platform\Stream\Command\CreateStreamCommand', $data);
    }

    /**
     * Delete a stream.
     *
     * @param $namespace
     * @param $slug
     * @return mixed
     */
    public function delete($namespace, $slug)
    {
        return $this->execute(new DeleteStreamCommand($namespace, $slug));
    }
}
