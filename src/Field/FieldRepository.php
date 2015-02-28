<?php namespace Anomaly\Streams\Platform\Field;

use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
use Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface;

/**
 * Class FieldRepository
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Field
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
     * @param array $attributes
     * @return FieldInterface
     */
    public function create(array $attributes)
    {
        $attributes['rules']  = array_get($attributes, 'rules', []);
        $attributes['config'] = array_get($attributes, 'config', []);
        $attributes['locked'] = (array_get($attributes, 'locked', true));

        return $this->model->create($attributes);
    }

    /**
     * Delete a field.
     *
     * @param FieldInterface $field
     */
    public function delete(FieldInterface $field)
    {
        $field->delete();
    }

    /**
     * Find a field by it's slug and namespace.
     *
     * @param  $slug
     * @param  $namespace
     * @return null|FieldInterface
     */
    public function findBySlugAndNamespace($slug, $namespace)
    {
        return $this->model->where('namespace', $namespace)->where('slug', $slug)->first();
    }

    /**
     * Delete garbage fields.
     */
    public function deleteGarbage()
    {
        $this->model
            ->leftJoin('streams_streams', 'streams_fields.namespace', '=', 'streams_streams.namespace')
            ->whereNull('streams_streams.id')
            ->delete();

        $this->model->where('slug', '')->delete();
        $this->model->where('namespace', '')->delete();
    }
}
