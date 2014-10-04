<?php namespace Streams\Platform\Assignment;

use Streams\Platform\Model\EloquentModel;
use Streams\Platform\Assignment\Event\FieldWasAssignedEvent;
use Streams\Platform\Assignment\Event\FieldWasUnassignedEvent;

class AssignmentModel extends EloquentModel
{
    /**
     * Do not use timestamp columns.
     *
     * @var bool
     */
    public $timestamps = false;

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
     * Add an assignment.
     *
     * @param $sortOrder
     * @param $streamId
     * @param $fieldId
     * @param $name
     * @param $instructions
     * @param $settings
     * @param $rules
     * @param $isTranslatable
     * @param $isRevisionable
     * @return $this
     */
    public function add(
        $sortOrder,
        $streamId,
        $fieldId,
        $name,
        $instructions,
        $settings,
        $rules,
        $isTranslatable,
        $isRevisionable
    ) {
        $this->name            = $name;
        $this->rules           = $rules;
        $this->field_id        = $fieldId;
        $this->settings        = $settings;
        $this->stream_id       = $streamId;
        $this->sort_order      = $sortOrder;
        $this->instructions    = $instructions;
        $this->is_translatable = $isTranslatable;
        $this->is_revisionable = $isRevisionable;

        $this->save();

        $this->raise(new FieldWasAssignedEvent($this));

        return $this;
    }

    /**
     * Remove an assignment.
     *
     * @param $streamId
     * @param $fieldId
     * @return $this|bool
     */
    public function remove($streamId, $fieldId)
    {
        $assignment = $this->whereStreamId($streamId)->whereFieldId($fieldId)->first();

        if ($assignment) {
            $assignment->delete();

            $this->raise(new FieldWasUnassignedEvent($assignment));

            return $this;
        }

        return false;
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
        return $this->belongsTo('Streams\Platform\Stream\StreamModel', 'stream_id');
    }

    /**
     * Return the field relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function field()
    {
        return $this->belongsTo('Streams\Platform\Field\FieldModel');
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
