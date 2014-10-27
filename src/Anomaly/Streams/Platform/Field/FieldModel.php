<?php namespace Anomaly\Streams\Platform\Field;

use Anomaly\Streams\Platform\Model\EloquentModel;

class FieldModel extends EloquentModel
{
    /**
     * Don't use timestamp / meta columns.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Define the table name
     *
     * @var string
     */
    protected $table = 'streams_fields';

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        self::observe(new FieldObserver());
    }

    /**
     * Add a field.
     *
     * @param       $slug
     * @param       $namespace
     * @param       $name
     * @param       $type
     * @param array $rules
     * @param array $settings
     * @param       $isLocked
     * @return $this
     */
    public function add($namespace, $slug, $name, $type, array $rules, array $settings, $isLocked)
    {
        $this->slug      = $slug;
        $this->name      = $name;
        $this->type      = $type;
        $this->rules     = $rules;
        $this->settings  = $settings;
        $this->is_locked = $isLocked;
        $this->namespace = $namespace;

        $this->save();

        //$this->raise(new FieldInstalledEvent($this));

        return $this;
    }

    /**
     * Remove a field.
     *
     * @param $namespace
     * @param $slug
     * @return $this
     */
    public function remove($namespace, $slug)
    {
        if ($field = $this->whereNamespace($namespace)->whereSlug($slug)->first()) {
            $field->delete();

            //$this->raise(new FieldUninstalledEvent($this));

            return $this;
        }

        return false;
    }

    /**
     * Find a field by namespace and slug.
     *
     * @param $namespace
     * @param $slug
     * @return mixed
     */
    public function findByNamespaceAndSlug($namespace, $slug)
    {
        return $this->whereNamespace($namespace)->whereSlug($slug)->first();
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
     * Return the assignments relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function assignments()
    {
        return $this->hasMany('Anomaly\Streams\Platform\Assignment\AssignmentModel', 'field_id');
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

    public function decorate()
    {
        return new FieldPresenter($this);
    }

    public function newCollection(array $items = [])
    {
        return new FieldCollection($items);
    }
}
