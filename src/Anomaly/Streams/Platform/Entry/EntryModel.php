<?php namespace Anomaly\Streams\Platform\Entry;

use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeAddon;
use Anomaly\Streams\Platform\Assignment\AssignmentModel;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Stream\StreamModel;

class EntryModel extends EloquentModel implements EntryInterface
{

    /**
     * Stream data
     *
     * @var array/null
     */
    protected $stream = [];

    /**
     * Create a new EntryModel instance.
     */
    public function __construct($attributes = [])
    {
        parent::__construct($attributes);

        $this->stream = (new StreamModel())->object($this->stream);

        $this->stream->parent = $this;
    }

    /**
     * Return the default columns.
     *
     * @return array
     */
    public function defaultColumns()
    {
        return [$this->getKeyName(), $this->CREATED_AT, 'createdByUser'];
    }

    /**
     * Set a given attribute on the model.
     *
     * @param  string $key
     * @param  mixed  $value
     * @return void
     */
    public function setAttribute($key, $value)
    {
        // If we have a field type for this key - use the field type
        // mutate method to transform the value to storage format.
        if ($assignment = $this->findAssignmentByFieldSlug($key)) {

            if ($type = $assignment->type($this) and $type instanceof FieldTypeAddon) {

                $value = $type->mutate($value);
            }
        }

        parent::setAttribute($key, $value);
    }

    /**
     * Set entry information that every record needs.
     *
     * @return $this
     */
    public function setMetaAttributes()
    {
        if (!$this->exists) {
            $createdBy = app('auth')->getUser()->getKey() or null;

            $this->setAttribute('created_by', $createdBy);
            $this->setAttribute('updated_at', null);
            $this->setAttribute('ordering_count', $this->count('id') + 1);
        } else {
            $updatedBy = app('auth')->getUser()->getKey() or null;

            $this->setAttribute('updated_by', $updatedBy);
            $this->setAttribute('updated_at', time());
        }

        return $this;
    }

    /**
     * Find an assignment by it's slug.
     *
     * @param $slug
     * @return mixed
     */
    public function findAssignmentByFieldSlug($slug)
    {
        return $this
            ->stream
            ->assignments
            ->findByFieldSlug($slug);
    }

    /**
     * Return a bootstrapped field type object.
     *
     * @param $slug
     * @return mixed
     */
    public function fieldType($slug)
    {
        return $this->findAssignmentByFieldSlug($slug)->fieldType();
    }

    /**
     * Get the stream data.
     *
     * @return array
     */
    public function getStream()
    {
        return $this->stream;
    }

    /**
     * Return the table name with the stream prefix.
     *
     * @return string
     */
    public function getTable()
    {
        $stream = $this->getStream();

        return $stream->prefix . $stream->slug;
    }

    /**
     * Return a new collection instance.
     *
     * @param array $items
     * @return \Illuminate\Database\Eloquent\Collection|EntryCollection
     */
    public function newCollection(array $items = [])
    {
        return new EntryCollection($items);
    }

    public function decorate()
    {
        return new EntryPresenter($this);
    }

    /**
     * Get the assignment object for a field.
     *
     * @param $field
     * @return mixed
     */
    public function getAssignmentFromField($field)
    {
        return $this->stream->assignments->findByFieldSlug($field);
    }

    /**
     * Get the field from a field.
     *
     * @param $field
     * @return mixed|null
     */
    public function getTypeFromField($field)
    {
        $assignment = $this->getAssignmentFromField($field);

        if ($assignment instanceof AssignmentModel) {

            return $assignment->type($this);
        }

        return null;
    }

    /**
     * Return a value from a field.
     *
     * @param $field
     * @return mixed
     */
    public function getValueFromField($field)
    {
        $fieldType = $this->getTypeFromField($field);

        if ($fieldType instanceof FieldTypeAddon) {

            return $fieldType->decorate();
        }

        return null;
    }

    /**
     * Get the name of a field.
     *
     * @param $field
     * @return mixed
     */
    public function getFieldName($field)
    {
        $assignment = $this->getAssignmentFromField($field);

        if ($assignment instanceof AssignmentModel) {

            return $assignment->getFieldName();
        }
    }

    /**
     * Get the heading for a field.
     *
     * @param $field
     * @return mixed
     */
    public function getFieldHeading($field)
    {
        return $this->getFieldName($field);
    }

    /**
     * Get the label for a field.
     *
     * @param $field
     * @return mixed
     */
    public function getFieldLabel($field)
    {
        $assignment = $this->getAssignmentFromField($field);

        if ($assignment instanceof AssignmentModel) {

            if ($label = $assignment->getFieldLabel()) {

                return $label;
            }
        }

        return $this->getFieldName($field);
    }

    /**
     * Get the placeholder for a field.
     *
     * @param $field
     * @return mixed
     */
    public function getFieldPlaceholder($field)
    {
        $name = $this->getFieldName($field);

        $placeholder = str_replace('.name', '.placeholder', $name);

        if ($translated = trans($placeholder) and $translated != $placeholder) {

            return $placeholder;
        }

        return null;
    }

    /**
     * Get a specified relationship.
     *
     * @param  string $relation
     * @return mixed
     */
    public function getRelation($relation)
    {
        if (isset($this->relations[$relation])) {

            return parent::getRelation($relation);
        }

        return null;
    }
}
