<?php namespace Anomaly\Streams\Platform\Field;

use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
use Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface;

/**
 * Class FieldRepository
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Field
 */
class FieldRepository implements FieldRepositoryInterface
{
    /**
     * The field model.
     *
     * @var
     */
    protected $model;

    /**
     * Create a new FieldRepository instance.
     *
     * @param FieldModel $model
     */
    public function __construct(FieldModel $model)
    {
        $this->model = $model;
    }

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
     * @return mixed|static
     */
    public function create($namespace, $slug, $name, $type, array $rules = [], array $config = [], $isLocked = true)
    {
        $field = $this->model->newInstance();

        $field->slug      = $slug;
        $field->name      = $name;
        $field->type      = $type;
        $field->rules     = $rules;
        $field->config    = $config;
        $field->is_locked = $isLocked;
        $field->namespace = $namespace;

        $field->save();

        return $field;
    }

    /**
     * Delete a field.
     *
     * @param $namespace
     * @param $slug
     * @return FieldInterface
     */
    public function delete($namespace, $slug)
    {
        $field = $this->findByNamespaceAndSlug($namespace, $slug);

        $field->delete();

        return $field;
    }

    /**
     * Find a field by it's namespace and slug.
     *
     * @param $namespace
     * @param $slug
     * @return FieldInterface|null
     */
    public function findByNamespaceAndSlug($namespace, $slug)
    {
        return $this->model->where('namespace', $namespace)->where('slug', $slug)->first();
    }

    /**
     * Get all fields with the given namespace.
     *
     * @param $namespace
     * @return mixed
     */
    public function getAllWithNamespace($namespace)
    {
        return $this->model->where('namespace', $namespace)->get();
    }

    /**
     * Delete garbage.
     *
     * @return mixed
     */
    public function deleteGarbage()
    {
        return $this
            ->table('streams_fields')
            ->leftJoin('streams_streams', 'streams_fields.namespace', '=', 'streams_streams.namespace')
            ->whereNull('streams_streams.id')
            ->delete();
    }
}
