<?php namespace Anomaly\Streams\Platform\Stream\Contract;

use Anomaly\Streams\Platform\Model\EloquentCollection;
use Anomaly\Streams\Platform\Model\EloquentModel;

/**
 * Interface StreamRepositoryInterface
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Stream\Contract
 */
interface StreamRepositoryInterface
{

    /**
     * Get all streams.
     *
     * @return EloquentCollection
     */
    public function all();

    /**
     * Create a new Stream.
     *
     * @param array $attributes
     * @return StreamInterface
     */
    public function create(array $attributes);

    /**
     * Save a Stream.
     *
     * @param StreamInterface|EloquentModel $stream
     * @return bool
     */
    public function save(StreamInterface $stream);

    /**
     * Delete a Stream.
     *
     * @param StreamInterface|EloquentModel $stream
     * @return bool
     */
    public function delete(StreamInterface $stream);

    /**
     * Clean up abandoned streams.
     */
    public function cleanup();

    /**
     * Find a stream by it's namespace and slug.
     *
     * @param  $slug
     * @param  $namespace
     * @return null|StreamInterface
     */
    public function findBySlugAndNamespace($slug, $namespace);
}
