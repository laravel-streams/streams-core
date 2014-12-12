<?php namespace Anomaly\Streams\Platform\Stream;

use Anomaly\Streams\Platform\Assignment\AssignmentCollection;
use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Class StreamModel
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Stream
 */
class StreamModel extends EloquentModel implements StreamInterface
{
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
     * Boot the model.
     *
     * @return void
     */
    protected static function boot()
    {
        self::observe(new StreamObserver());
    }

    /**
     * Compile the entry models.
     *
     * @return mixed
     */
    public function compile()
    {
        $this->save(); // Saving triggers the observer compile event.
    }

    /**
     * Make a Stream instance from the provided compile data.
     *
     * @param array $data
     * @return StreamInterface
     */
    public function make(array $data)
    {
        $assignments = array();

        $streamModel = app('Anomaly\Streams\Platform\Stream\StreamModel');

        $data['view_options'] = serialize($data['view_options']);

        $streamModel->setRawAttributes($data);

        if (isset($data['assignments'])) {
            foreach ($data['assignments'] as $assignment) {
                if (isset($assignment['field'])) {
                    $assignment['field']['rules']  = unserialize($assignment['field']['rules']);
                    $assignment['field']['config'] = unserialize($assignment['field']['config']);

                    $fieldModel = app()->make('Anomaly\Streams\Platform\Field\FieldModel');

                    $fieldModel->fill($assignment['field']);

                    unset($assignment['field']);

                    $assignmentModel = app()->make('Anomaly\Streams\Platform\Assignment\AssignmentModel');

                    $assignmentModel->fill($assignment);

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
     * Get the ID.
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->getKey();
    }

    /**
     * Get the namespace.
     *
     * @return mixed
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Get the slug.
     *
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Get the prefix.
     *
     * @return mixed
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Get the name.
     *
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the translatable flag.
     *
     * @return mixed
     */
    public function isTranslatable()
    {
        return ($this->translatable);
    }

    /**
     * Get the title column.
     *
     * @return mixed
     */
    public function getTitleColumn()
    {
        return $this->title_column;
    }

    /**
     * Get the related assignments.
     *
     * @return AssignmentCollection
     */
    public function getAssignments()
    {
        return $this->assignments;
    }

    /**
     * Get an assignment by it's field's slug.
     *
     * @param $fieldSlug
     * @return AssignmentInterface
     */
    public function getAssignment($fieldSlug)
    {
        $assignments = $this->getAssignments();

        return $assignments->findByFieldSlug($fieldSlug);
    }

    /**
     * Get a stream field by it's slug.
     *
     * @param $slug
     * @return mixed
     */
    public function getField($slug)
    {
        if (!$assignment = $this->getAssignment($slug)) {
            return null;
        }

        return $assignment->getField();
    }

    /**
     * Get a field's type by the field's slug.
     *
     * @param $fieldSlug
     * @return mixed
     */
    public function getFieldType($fieldSlug)
    {
        if (!$assignment = $this->getAssignment($fieldSlug)) {
            return null;
        }

        return $assignment->getFieldType();
    }

    /**
     * Serialize the view options before setting them on the model.
     *
     * @param $viewOptions
     */
    public function setViewOptionsAttribute($viewOptions)
    {
        $this->attributes['view_options'] = serialize($viewOptions);
    }

    /**
     * Unserialize the view options after getting them off the model.
     *
     * @param $viewOptions
     * @return mixed
     */
    public function getViewOptionsAttribute($viewOptions)
    {
        return unserialize($viewOptions);
    }

    /**
     * Get the entry table name.
     *
     * @return string
     */
    public function getEntryTableName()
    {
        return $this->getPrefix() . $this->getSlug();
    }

    /**
     * Get the entry translations table name.
     *
     * @return string
     */
    public function getEntryTranslationsTableName()
    {
        return $this->getEntryTableName() . '_translations';
    }

    /**
     * Get the foreign key.
     *
     * @return string
     */
    public function getForeignKey()
    {
        return str_singular($this->getSlug()) . '_id';
    }


    /**
     * Return the assignments relation.
     *
     * @return mixed
     */
    public function assignments()
    {
        return $this->hasMany(config('streams::config.assignments.model'), 'stream_id')->orderBy('sort_order');
    }
}
