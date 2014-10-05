<?php namespace Streams\Platform\Addon\FieldType;

use Streams\Platform\Addon\Addon;

class FieldTypeAddon extends Addon
{
    protected $columnType = 'string';

    protected $colunmName = null;

    protected $fieldName = null;

    protected $value = null;

    public function input()
    {
        $options = [
            'class' => 'form-control',
        ];

        return \Form::text($this->getFieldName(), $this->value, $options);
    }

    public function element()
    {
        $for   = $this->getFieldName();
        $name  = $this->assignment->field->name;
        $input = $this->input();

        return \View::make('html/partials/element', compact('for', 'name', 'input'));
    }

    public function mutate($value)
    {
        return $value;
    }

    public function getColumnType()
    {
        return $this->columnType;
    }

    public function setColumnName($columnName)
    {
        $this->colunmName = $columnName;

        return $this;
    }

    public function getColumnName()
    {
        return $this->colunmName;
    }

    public function setFieldName($fieldName)
    {
        $this->fieldName = $fieldName;

        return $this;
    }

    public function getFieldName()
    {
        return $this->fieldName;
    }

    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function newPresenter()
    {
        return new FieldTypePresenter($this);
    }

    public function newServiceProvider()
    {
        return new FieldTypeServiceProvider($this->app);
    }
}
