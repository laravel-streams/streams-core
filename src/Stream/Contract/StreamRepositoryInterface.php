<?php namespace Anomaly\Streams\Platform\Stream\Contract;

use Anomaly\Streams\Platform\Model\Contract\EloquentRepositoryInterface;
use Anomaly\Streams\Platform\Model\EloquentCollection;
use Anomaly\Streams\Platform\Stream\StreamCollection;

/**
 * Interface StreamRepositoryInterface
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Stream\Contract
 */
interface StreamRepositoryInterface extends EloquentRepositoryInterface
{

    /**
     * Find a stream by it's namespace and slug.
     *
     * @param  $slug
     * @param  $namespace
     * @return null|StreamInterface
     */
    public function findBySlugAndNamespace($slug, $namespace);

    /**
     * Find all streams in a namespace.
     *
     * @param  $namespace
     * @return null|EloquentCollection
     */
    public function findAllByNamespace($namespace);

    /**
     * Destroy a namespace.
     *
     * @param $namespace
     */
    public function destroy($namespace);

    /**
     * Return streams that are/not hidden.
     *
     * @param $hidden
     * @return StreamCollection
     */
    public function hidden($hidden = true);

    /**
     * Return only visible streams.
     *
     * @return StreamCollection
     */
    public function visible();

    /**
     * Clean up abandoned streams.
     */
    public function cleanup();
}
