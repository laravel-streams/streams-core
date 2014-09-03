<?php namespace Streams\Core\Assignment\Model;

use Streams\Core\Field\Model\FieldModel;
use Streams\Core\Assignment\Schema\AssignmentSchema;
use Streams\Core\Assignment\Presenter\AssignmentPresenter;
use Streams\Core\Assignment\Collection\AssignmentCollection;

class AssignmentModel extends FieldModel
{
    /**
     * Define the table name
     *
     * @var string
     */
    protected $table = 'streams_assignments';

    /**
     * Clean up garbage records.
     * Be careful using this.
     * It can be very expensive.
     *
     * @return bool
     */
    public function cleanup()
    {
        $ids = FieldModel::all()->lists('id');

        if (!$ids) {
            return true;
        }

        return $this->whereNotIn('field_id', $ids)->delete();
    }

    /**
     * Return the stream relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stream()
    {
        return $this->belongsTo('Streams\Stream\Model\StreamModel', 'stream_id');
    }

    /**
     * Return the field relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function field()
    {
        return $this->belongsTo('Streams\Core\Field\Model\FieldModel');
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
     * @return AssignmentPresenter|\Streams\Core\Field\Presenter\FieldPresenter|\Streams\Presenter\EloquentPresenter
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
