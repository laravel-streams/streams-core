<?php namespace Streams\Platform\Addon\FieldType;

use Streams\Platform\Addon\Addon;

abstract class FieldType extends Addon
{
    protected $columnType = 'string';

    protected $columnConstraint = null;

    protected $elementView = 'html/partials/element';

    protected $entry = null;

    protected $value = null;

    protected $assignment = null;

    public function input()
    {
        $options = [
            'class' => 'form-control',
        ];

        return \Form::text($this->fieldName(), $this->value, $options);
    }

    public function element()
    {
        $for   = $this->fieldName();
        $name  = $this->assignment->field->name;
        $input = $this->input();

        return \View::make($this->elementView, compact('for', 'name', 'input'));
    }

    public function columnName()
    {
        return $this->assignment->field->slug;
    }

    public function fieldName()
    {
        return $this->assignment->field->slug;
    }

    public function mutate($value)
    {
        return $value;
    }

    public function getColumnType()
    {
        return $this->columnType;
    }

    public function getColumnConstraint()
    {
        return $this->columnConstraint;
    }

    public function getEntry()
    {
        return $this->entry;
    }

    public function setEntry($entry)
    {
        $this->entry = $entry;

        return $this;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    public function getAssignment()
    {
        return $this->assignment;
    }

    public function setAssignment($assignment)
    {
        $this->assignment = $assignment;

        return $this;
    }

    public function newPresenter($resource)
    {
        $class     = get_class($this);
        $presenter = $class . 'Presenter';

        if (class_exists($presenter)) {
            return new $presenter($resource);
        }

        return new FieldTypePresenter($resource);
    }
}
