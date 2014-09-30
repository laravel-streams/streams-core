<?php namespace Streams\Platform\Assignment\Model;

use Streams\Platform\Assignment\Observer\AssignmentObserver;
use Streams\Platform\Field\Model\FieldModel;
use Streams\Platform\Assignment\Schema\AssignmentSchema;
use Streams\Platform\Assignment\Presenter\AssignmentPresenter;
use Streams\Platform\Assignment\Collection\AssignmentCollection;

class AssignmentModel extends FieldModel
{
    /**
     * Define the table name
     *
     * @var string
     */
    protected $table = 'streams_assignments';

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        self::observe(new AssignmentObserver());
    }

    /**
     * Find orphaned assignments.
     *
     * @return mixed
     */
    public function findAllOrphaned()
    {
        return $this->select('streams_assignments.*')
            ->leftJoin('streams_streams', 'streams_assignments.stream_id', '=', 'streams_streams.id')
            ->leftJoin('streams_fields', 'streams_assignments.field_id', '=', 'streams_fields.id')
            ->whereNull('streams_streams.id')
            ->orWhereNull('streams_fields.id')
            ->get();
    }

    /**
     * Return the field type.
     *
     * @return mixed
     */
    public function fieldType()
    {
        return $this->field->type;
    }

    /**
     * Return the stream relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stream()
    {
        return $this->belongsTo('Streams\Platform\Stream\Model\StreamModel', 'stream_id');
    }

    /**
     * Return the field relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function field()
    {
        return $this->belongsTo('Streams\Platform\Field\Model\FieldModel');
    }

    /**
     * Return a new collection instance.
     *
     * @param array $items
     * @return \Illuminate\Database\Eloquent\Collection|AssignmentCollection
     */
    public function newCollection(array $items = [])
    {
        return new AssignmentCollection($items);
    }

    /**
     * Return a new presenter instance.
     *
     * @param $resource
     * @return AssignmentPresenter|\Streams\Platform\Field\Presenter\FieldPresenter|\Streams\Presenter\EloquentPresenter
     */
    public function newPresenter($resource)
    {
        return new AssignmentPresenter($resource);
    }

    /**
     * Return a new assignment schema instance.
     *
     * @return AssignmentSchema
     */
    public function newSchema()
    {
        return new AssignmentSchema($this);
    }
}
