<?php namespace Anomaly\Streams\Platform\Stream\Contract;

/**
 * Interface StreamRepositoryInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Stream\Contract
 */
interface StreamRepositoryInterface
{

    /**
     * Create a new Stream.
     *
     * @param        $namespace
     * @param        $slug
     * @param        $name
     * @param null   $prefix
     * @param null   $description
     * @param array  $viewOptions
     * @param string $titleColumn
     * @param string $orderBy
     * @param bool   $locked
     * @param bool   $translatable
     * @return StreamInterface
     */
    public function create(
        $namespace,
        $slug,
        $name,
        $prefix = null,
        $description = null,
        array $viewOptions = [],
        $titleColumn = 'id',
        $orderBy = 'id',
        $locked = false,
        $translatable = false
    );

    /**
     * Delete a Stream.
     *
     * @param $namespace
     * @param $slug
     * @return mixed
     */
    public function delete($namespace, $slug);

    /**
     * Find a stream by it's namespace and slug.
     *
     * @param $namespace
     * @param $slug
     * @return mixed
     */
    public function findByNamespaceAndSlug($namespace, $slug);

    /**
     * Get all streams with a given namespace.
     *
     * @param $namespace
     * @return mixed
     */
    public function getAllWithNamespace($namespace);
}
