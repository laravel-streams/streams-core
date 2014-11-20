<?php namespace Anomaly\Streams\Platform\Stream;

use Anomaly\Streams\Platform\Assignment\AssignmentCollection;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

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

                    $fieldModel = app()->make('Anomaly\Streams\Platform\Field\FieldModel', $assignment['field']);

                    unset($assignment['field']);

                    $assignmentModel = app()->make('Anomaly\Streams\Platform\Assignment\AssignmentModel', $assignment);

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
        return ($this->is_translatable);
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
     * Return the assignments relation.
     *
     * @return mixed
     */
    public function assignments()
    {
        return $this->hasMany(config('streams.assignments.model'), 'stream_id')->orderBy('sort_order');
    }
}
