<?php namespace Anomaly\Streams\Platform\Field\Contract;

/**
 * Interface FieldRepositoryInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Field\Contract
 */
interface FieldRepositoryInterface
{

    /**
     * Create a new field.
     *
     * @param       $namespace
     * @param       $slug
     * @param       $name
     * @param       $type
     * @param array $rules
     * @param array $config
     * @param bool  $isLocked
     * @return mixed
     */
    public function create($namespace, $slug, $name, $type, array $rules = [], array $config = [], $isLocked = true);

    /**
     * Delete a field.
     *
     * @param $namespace
     * @param $slug
     * @return FieldInterface
     */
    public function delete($namespace, $slug);

    /**
     * Find a field by it's namespace and slug.
     *
     * @param $namespace
     * @param $slug
     * @return mixed
     */
    public function findByNamespaceAndSlug($namespace, $slug);

    /**
     * Get all fields with the given namespace.
     *
     * @param $namespace
     * @return mixed
     */
    public function getAllWithNamespace($namespace);

    /**
     * Delete garbage.
     *
     * @return mixed
     */
    public function deleteGarbage();
}
 