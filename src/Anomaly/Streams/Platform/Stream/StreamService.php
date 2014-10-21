<?php namespace Anomaly\Streams\Platform\Stream;

use Anomaly\Streams\Platform\Traits\CommandableTrait;
use Anomaly\Streams\Platform\Stream\Command\AddStreamCommand;
use Anomaly\Streams\Platform\Stream\Command\RemoveStreamCommand;

class StreamService
{
    use CommandableTrait;

    /**
     * Add a stream.
     *
     * @param array $stream
     * @return mixed
     */
    public function add(array $stream)
    {
        // Mandatory properties.
        $slug      = $stream['slug'];
        $namespace = $stream['namespace'];

        // Optional properties
        $prefix         = isset($stream['prefix']) ? $stream['prefix'] : $namespace . '_';
        $viewOptions    = isset($stream['view_options']) ? $stream['view_options'] : ['id', 'created_at'];
        $titleColumn    = isset($stream['title_column']) ? $stream['title_column'] : 'id';
        $orderBy        = isset($stream['order_by']) ? $stream['order_by'] : 'id';
        $isHidden       = isset($stream['is_hidden']) ? $stream['is_hidden'] : false;
        $isTranslatable = isset($stream['is_translatable']) ? $stream['is_translatable'] : false;
        $isRevisionable = isset($stream['is_revisionable']) ? $stream['is_revisionable'] : false;

        // Determine the stream name.
        if (!isset($stream['name'])) {
            if (isset($stream['lang'])) {
                $stream['name'] = "{$stream['lang']}::stream.{$stream['slug']}.name";
            }
        }

        $name = isset($stream['name']) ? $stream['name'] : null;

        // Determine the stream description.
        if (!isset($stream['description'])) {
            if (isset($stream['lang'])) {
                $stream['description'] = "{$stream['lang']}::stream.{$stream['slug']}.description";
            }
        }

        $description = isset($stream['description']) ? $stream['description'] : null;

        $command = new AddStreamCommand(
            $namespace,
            $slug,
            $prefix,
            $name,
            $description,
            $viewOptions,
            $titleColumn,
            $orderBy,
            $isHidden,
            $isTranslatable,
            $isRevisionable
        );

        return $this->execute($command);
    }

    /**
     * Remove a stream.
     *
     * @param $namespace
     * @param $slug
     * @return mixed
     */
    public function remove($namespace, $slug)
    {
        $command = new RemoveStreamCommand($namespace, $slug);

        return $this->execute($command);
    }
}
