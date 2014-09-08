<?php namespace Streams\Core\Addon;

use Streams\Core\Addon\Model\FieldTypeModel;
use Streams\Core\Addon\Presenter\FieldTypePresenter;

abstract class FieldTypeAbstract extends AddonAbstract
{
    /**
     * The database column type.
     *
     * @var string
     */
    protected $columnType = 'string';

    /**
     * The column constraint.
     *
     * @var string
     */
    protected $columnConstraint = null;

    /**
     * The entry model object.
     *
     * @var null
     */
    protected $entry = null;

    /**
     * The value.
     *
     * @var null
     */
    protected $value = null;

    /**
     * The field assignment model object.
     *
     * @var null
     */
    protected $assignment = null;

    /**
     * Return the form input.
     *
     * @return string
     */
    public function input()
    {
        $options = [
            'class' => 'form-control',
        ];

        return \Form::text($this->fieldName(), $this->value, $options);
    }

    /**
     * Return the form input element output.
     *
     * @return mixed
     */
    public function element()
    {
        $field = $this->assignment->field;

        return \View::make('html/partials/element', compact('field'));
    }

    /**
     * Return the database column name.
     *
     * @return string
     */
    public function columnName()
    {
        return $this->assignment->field->slug;
    }

    /**
     * Return the field name.
     *
     * @return string
     */
    public function fieldName()
    {
        return $this->assignment->field->slug;
    }

    /**
     * Mutate the value for storage.
     *
     * @param $value
     * @return mixed
     */
    public function mutate($value)
    {
        return $value;
    }

    /**
     * Return the column type.
     *
     * @return string
     */
    public function getColumnType()
    {
        return $this->columnType;
    }

    /**
     * Return the column constraint.
     *
     * @return string
     */
    public function getColumnConstraint()
    {
        return $this->columnConstraint;
    }

    /**
     * Get the entry object.
     *
     * @return null
     */
    public function getEntry()
    {
        return $this->entry;
    }

    /**
     * Set the entry model object.
     *
     * @param $entry
     * @return $this
     */
    public function setEntry($entry)
    {
        $this->entry = $entry;

        return $this;
    }

    /**
     * Get the value.
     *
     * @return null
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value.
     *
     * @param $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get the assignment object.
     *
     * @return null
     */
    public function getAssignment()
    {
        return $this->assignment;
    }

    /**
     * Set the field assignment model.
     *
     * @param $assignment
     * @return $this
     */
    public function setAssignment($assignment)
    {
        $this->assignment = $assignment;

        return $this;
    }

    /**
     * Return a new FieldTypeModel instance.
     *
     * @return null|FieldTypeModel
     */
    public function newModel()
    {
        return new FieldTypeModel();
    }

    /**
     * Return a new presenter instance.
     *
     * @param $resource
     * @return null|FieldTypePresenter
     */
    public function newPresenter($resource)
    {
        return new FieldTypePresenter($resource);
    }
}
