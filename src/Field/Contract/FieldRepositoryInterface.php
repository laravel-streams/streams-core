<?php namespace Anomaly\Streams\Platform\Field\Contract;

use Anomaly\Streams\Platform\Field\FieldCollection;

/**
 * Interface FieldRepositoryInterface
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Field\Contract
 */
interface FieldRepositoryInterface
{

    /**
     * Create a new field.
     *
     * @param array $attributes
     * @return FieldInterface
     */
    public function create(array $attributes);

    /**
     * Delete a field.
     *
     * @param FieldInterface $field
     */
    public function delete(FieldInterface $field);

    /**
     * Find a field by it's slug and namespace.
     *
     * @param  $slug
     * @param  $namespace
     * @return null|FieldInterface
     */
    public function findBySlugAndNamespace($slug, $namespace);

    /**
     * Return all fields in a namespace.
     *
     * @param  $namespace
     * @return FieldCollection
     */
    public function findByNamespace($namespace);

    /**
     * Delete garbage fields.
     */
    public function deleteGarbage();
}
