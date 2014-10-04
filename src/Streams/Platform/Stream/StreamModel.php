<?php namespace Streams\Platform\Stream;

use Streams\Platform\Field\FieldModel;
use Streams\Platform\Model\EloquentModel;
use Streams\Platform\Assignment\AssignmentModel;
use Streams\Platform\Assignment\AssignmentCollection;

class StreamModel extends EloquentModel
{
    /**
     * Use timestamp and meta columns.
     */
    public $timestamps = false;

    /**
     * The model's database table name.
     *
     * @var string
     */
    protected $table = 'streams_streams';

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        self::observe(new StreamObserver());
    }

    /**
     * Add a stream.
     *
     * @param $namespace
     * @param $slug
     * @param $prefix
     * @param $name
     * @param $description
     * @param $viewOptions
     * @param $titleColumn
     * @param $orderBy
     * @param $isHidden
     * @param $isTranslatable
     * @param $isRevisionable
     * @return $this
     */
    public function add(
        $namespace,
        $slug,
        $prefix,
        $name,
        $description,
        $viewOptions,
        $titleColumn,
        $orderBy,
        $isHidden,
        $isTranslatable,
        $isRevisionable
    ) {
        $this->slug            = $slug;
        $this->name            = $name;
        $this->prefix          = $prefix;
        $this->order_by        = $orderBy;
        $this->is_hidden       = $isHidden;
        $this->namespace       = $namespace;
        $this->description     = $description;
        $this->view_options    = $viewOptions;
        $this->title_column    = $titleColumn;
        $this->is_translatable = $isTranslatable;
        $this->is_revisionable = $isRevisionable;

        $this->save();

        //$this->raise();

        return $this;
    }

    /**
     * Remove a stream.
     *
     * @param $namespace
     * @param $slug
     * @return $this|bool
     */
    public function remove($namespace, $slug)
    {
        if ($stream = $this->whereNamespace($namespace)->whereSlug($slug)->first()) {
            $stream->delete();

            //$this->raise();

            return $stream;
        }

        return false;
    }

    /**
     * Return all streams with given namespace.
     *
     * @param $namespace
     * @return mixed
     */
    public function findAllByNamespace($namespace)
    {
        return $this->whereNamespace($namespace)->get();
    }

    /**
     * Find by namespace and slug.
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
     * Return the entry table name.
     *
     * @return string
     */
    public function entryTable()
    {
        return $this->prefix . $this->slug;
    }

    /**
     * Return the translatable table name.
     *
     * @return string
     */
    public function translatableTable()
    {
        return $this->entryTable() . '_translations';
    }

    /**
     * Return the singular slug inflection.
     *
     * @return string
     */
    public function singular()
    {
        return str_singular($this->slug);
    }

    public function object($data)
    {
        $assignments = array();

        $streamModel = new StreamModel();

        $streamModel->setRawAttributes($data);

        if (isset($data['assignments'])) {
            foreach ($data['assignments'] as $assignment) {
                if (isset($assignment['field'])) {
                    $fieldModel = new FieldModel($assignment['field']);

                    unset($assignment['field']);

                    $assignmentModel = new AssignmentModel($assignment);

                    $assignmentModel->setRawAttributes($assignment);

                    $assignmentModel->setRelation('field', $fieldModel);
                    $assignmentModel->setRelation('stream', $streamModel);

                    $assignments[] = $assignmentModel;
                }
            }
        }

        $assignmentsCollection = new AssignmentCollection($assignments);

        $streamModel->setRelation('assignments', $assignmentsCollection);

        $streamModel->assignments = $assignmentsCollection;

        return $streamModel;
    }

    /**
     * Get the view options attribute.
     *
     * @param  string $viewOptions
     * @return array
     */
    public function getViewOptionsAttribute(
        $viewOptions
    ) {
        return json_decode($viewOptions);
    }

    /**
     * Set the view options attribute.
     *
     * @param array $viewOptions
     */
    public function setViewOptionsAttribute($viewOptions)
    {
        $this->attributes['view_options'] = json_encode($viewOptions);
    }

    /**
     * Get the permissions attribute.
     *
     * @param  string $permissions
     * @return array
     */
    public function getPermissionsAttribute($permissions)
    {
        return json_decode($permissions);
    }

    /**
     * Set the permissions attribute.
     *
     * @param array $permissions
     */
    public function setPermissionsAttribute($permissions)
    {
        $this->attributes['permissions'] = json_encode($permissions);
    }

    /**
     * Return a new collection instance.
     *
     * @param array $items
     * @return \Illuminate\Database\Eloquent\Collection|StreamCollection
     */
    public function newCollection(array $items = [])
    {
        return new StreamCollection($items);
    }

    public function newPresenter()
    {
        return new StreamPresenter($this);
    }

    /**
     * Return a new stream schema instance.
     *
     * @return StreamSchema
     */
    public function newSchema()
    {
        return new StreamSchema($this);
    }

    /**
     * Return the assignments relationship.
     *
     * @return object
     */
    public function assignments()
    {
        return $this->hasMany('Streams\Platform\Assignment\AssignmentModel', 'stream_id')->orderBy('sort_order');
    }
}
