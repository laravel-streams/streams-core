<?php namespace Streams\Platform\Stream\Model;

use Streams\Platform\Model\EloquentModel;
use Streams\Platform\Field\Model\FieldModel;
use Streams\Platform\Stream\Observer\StreamObserver;
use Streams\Platform\Stream\Presenter\StreamPresenter;
use Streams\Platform\Stream\Schema\StreamSchema;
use Streams\Platform\Assignment\Model\AssignmentModel;
use Streams\Platform\Stream\Collection\StreamCollection;
use Streams\Platform\Assignment\Collection\AssignmentCollection;

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
     * Find by slug and namespace.
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
    public function getViewOptionsAttribute($viewOptions)
    {
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

    /**
     * Return a new presenter instance.
     *
     * @param $resource
     * @return \Streams\Presenter\EloquentPresenter|StreamPresenter
     */
    public function newPresenter($resource)
    {
        return new StreamPresenter($resource);
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
        return $this->hasMany('Streams\Platform\Assignment\Model\AssignmentModel', 'stream_id')->orderBy('sort_order');
    }
}
