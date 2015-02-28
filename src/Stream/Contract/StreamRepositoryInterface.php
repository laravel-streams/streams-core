<?php namespace Anomaly\Streams\Platform\Stream\Contract;

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
     * Create a new Stream.
     *
     * @param array $attributes
     * @return StreamInterface
     */
    public function create(array $attributes);

    /**
     * Delete a Stream.
     *
     * @param StreamInterface $stream
     */
    public function delete(StreamInterface $stream);

    /**
     * Find a stream by it's namespace and slug.
     *
     * @param  $slug
     * @param  $namespace
     * @return null|StreamInterface
     */
    public function findBySlugAndNamespace($slug, $namespace);
}
