<?php namespace Anomaly\Streams\Platform\Stream;

use Anomaly\Streams\Platform\Assignment\AssignmentCollection;
use Anomaly\Streams\Platform\Assignment\AssignmentModel;
use Anomaly\Streams\Platform\Field\FieldModel;
use Anomaly\Streams\Platform\Model\EloquentModel;

class StreamModel extends EloquentModel
{

    /**
     * Do not use timestamps.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * This model is translatable.
     *
     * @var bool
     */
    protected $translatable = true;

    /**
     * The foreign key for translations.
     *
     * @var string
     */
    protected $translationForeignKey = 'stream_id';

    /**
     * The model's database table name.
     *
     * @var string
     */
    protected $table = 'streams_streams';

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

            //$this->raise(new StreamWasRemovedEvent($stream));

            return $stream;
        }

        return false;
    }

    public function findAllByNamespace($namespace)
    {
        return $this->whereNamespace($namespace)->get();
    }

    public function findByNamespaceAndSlug($namespace, $slug)
    {
        return $this->whereNamespace($namespace)->whereSlug($slug)->first();
    }

    public function getEntryTableName()
    {
        return $this->prefix . $this->slug;
    }

    public function getEntryTranslationsTableName()
    {
        return $this->getEntryTableName() . '_translations';
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

    public function assignments()
    {
        return $this->hasMany('Anomaly\Streams\Platform\Assignment\AssignmentModel', 'stream_id')->orderBy(
            'sort_order'
        );
    }

    public function getViewOptionsAttribute($viewOptions)
    {
        return json_decode($viewOptions);
    }

    public function setViewOptionsAttribute($viewOptions)
    {
        $this->attributes['view_options'] = json_encode($viewOptions);
    }

    public function getPermissionsAttribute($permissions)
    {
        return json_decode($permissions);
    }

    public function setPermissionsAttribute($permissions)
    {
        $this->attributes['permissions'] = json_encode($permissions);
    }

    public function getForeignKey()
    {
        return str_singular($this->slug) . '_id';
    }

    public function newCollection(array $items = [])
    {
        return new StreamCollection($items);
    }

    public function decorate()
    {
        return new StreamPresenter($this);
    }

    public function isTranslatable()
    {
        return ($this->is_translatable);
    }
}
