<?php namespace Streams\Platform\Addon\FieldType;

use Streams\Platform\Addon\Addon;

class FieldTypeAddon extends Addon
{

    // TODO: use terms like slug and reserve name for logic returns (get name = slug."_id")
    // TODO: basically stick to terms used in DB

    protected $type = 'field_type';

    protected $columnType = 'string';

    protected $name = null;

    protected $value = null;

    public function input()
    {
        $options = [
            'class' => 'form-control',
        ];

        return \Form::text($this->name, $this->value, $options);
    }

    public function element()
    {
        $for   = $this->name;
        $name  = $this->name;
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

    public function getColumnName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
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
