<?php namespace Anomaly\Streams\Platform\Field;

use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
use Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface;
use Anomaly\Streams\Platform\Model\EloquentRepository;

/**
 * Class FieldRepository
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Field
 */
class FieldRepository extends EloquentRepository implements FieldRepositoryInterface
{

    /**
     * The field model.
     *
     * @var FieldModel
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
    public function create(array $attributes = [])
    {
        $attributes['config'] = array_get($attributes, 'config', []);
        $attributes['locked'] = (array_get($attributes, 'locked', true));

        return $this->model->create($attributes);
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
     * Return all fields in a namespace.
     *
     * @param  $namespace
     * @return FieldCollection
     */
    public function findAllByNamespace($namespace)
    {
        return $this->model->where('namespace', $namespace)->get();
    }

    /**
     * Clean up abandoned fields.
     */
    public function cleanup()
    {
        $fieldTypes = app('field_type.collection')->lists('namespace');

        $this->model
            ->leftJoin('streams_streams', 'streams_fields.namespace', '=', 'streams_streams.namespace')
            ->whereNull('streams_streams.id')
            ->delete();

        $this->model->where('slug', '')->delete();
        $this->model->where('namespace', '')->delete();
        $this->model->whereNotIn('type', $fieldTypes)->delete();

        $translations = $this->model->getTranslationModel();

        $translations
            ->leftJoin(
                'streams_fields',
                'streams_fields_translations.field_id',
                '=',
                'streams_fields.id'
            )
            ->whereNull('streams_fields.id')
            ->delete();
    }
}
