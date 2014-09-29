<?php namespace Streams\Platform\Field\Model;

use Streams\Platform\Model\EloquentModel;
use Streams\Platform\Field\Presenter\FieldPresenter;
use Streams\Platform\Assignment\Model\AssignmentModel;
use Streams\Platform\Field\Collection\FieldCollection;

class FieldModel extends EloquentModel
{
    /**
     * Don't use timestamp / meta columns.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The field type object.
     *
     * @var null
     */
    protected $type = null;

    /**
     * Define the table name
     *
     * @var string
     */
    protected $table = 'streams_fields';

    /**
     * Find a field by slug and namespace.
     *
     * @param $slug
     * @param $namespace
     * @return mixed
     */
    public function findBySlugAndNamespace($slug, $namespace)
    {
        return $this->whereSlug($slug)->whereNamespace($namespace)->first();
    }

    /**
     * Find all fields by namespace.
     *
     * @param $namespace
     * @return mixed
     */
    public function findAllByNamespace($namespace)
    {
        return $this->whereNamespace($namespace)->get();
    }

    /**
     * Find all orphaned fields.
     *
     * @return mixed
     */
    public function findAllOrphaned()
    {
        return $this->select('streams_fields.*')
                ->leftJoin('streams_streams', 'streams_fields.namespace', '=', 'streams_streams.namespace')
                ->whereNull('streams_streams.id')
                ->get();
    }

    /**
     * Get a setting value.
     *
     * @param      $key
     * @param null $default
     * @return null
     */
    public function getSetting($key, $default = null)
    {
        return isset($this->settings->{$key}) ? $this->settings->{$key} : $default;
    }

    /**
     * Get field name attribute.
     *
     * @param $name
     * @return string
     */
    public function getFieldNameAttribute($name)
    {
        return trans($name);
    }

    /**
     * Return the decoded settings attribute.
     *
     * @param $settings
     * @return mixed
     */
    public function getSettingsAttribute($settings)
    {
        return json_decode($settings);
    }

    /**
     * Set settings attribute.
     *
     * @param array $settings
     */
    public function setSettingsAttribute($settings)
    {
        $this->attributes['settings'] = json_encode($settings);
    }

    /**
     * Return the decoded rules attribute.
     *
     * @param $rules
     * @return mixed
     */
    public function getRulesAttribute($rules)
    {
        return json_decode($rules);
    }

    /**
     * Set rules attribute.
     *
     * @param array $rules
     */
    public function setRulesAttribute($rules)
    {
        $this->attributes['rules'] = json_encode($rules);
    }

    /**
     * Return the type attribute.
     *
     * @param $type
     * @return \AddonAbstract
     */
    public function getTypeAttribute($type)
    {
        if (\FieldType::exists($type)) {
            $type = \FieldType::find($type);
        }

        return $type;
    }

    /**
     * Return a new presenter instance.
     *
     * @param $resource
     * @return \Streams\Presenter\EloquentPresenter|FieldPresenter
     */
    public function newPresenter($resource)
    {
        return new FieldPresenter($resource);
    }

    /**
     * Return the assignments relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function assignments()
    {
        return $this->hasMany('Streams\Platform\Assignment\Model\AssignmentModel', 'field_id');
    }

    /**
     * Return a new collection instance.
     *
     * @param array $items
     * @return \Illuminate\Database\Eloquent\Collection|FieldCollection
     */
    public function newCollection(array $items = [])
    {
        return new FieldCollection($items);
    }
}
