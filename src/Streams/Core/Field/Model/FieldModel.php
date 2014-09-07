<?php namespace Streams\Core\Field\Model;

use Streams\Core\Model\EloquentModel;
use Streams\Core\Field\Presenter\FieldPresenter;
use Streams\Core\Field\Collection\FieldCollection;

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
     * Clean up garbage records.
     * Be careful using this.
     * It can be very expensive.
     *
     * @return bool
     */
    public function cleanup()
    {
        $ids = AssignmentModel::all()->lists('id');

        if (!$ids) {
            return true;
        }

        return $this->whereNotIn('id', $ids)->delete();
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
        return \Lang::trans($name);
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
            $type = \FieldType::find($type)
                ->setAssignment($this->parent)
                ->setEntry($this->parent->stream->parent)
                ->setValue($this->parent->stream->parent->getAttributeValue($this->slug));
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
        return $this->hasMany('Streams\Model\AssignmentModel', 'field_id');
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
