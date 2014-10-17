<?php namespace Streams\Platform\Addon\FieldType;

use Streams\Platform\Addon\Addon;
use Streams\Platform\Contract\PresentableInterface;

class FieldTypeAddon extends Addon implements PresentableInterface
{
    protected $slug = null;

    protected $type = 'field_type';

    protected $columnType = 'string';

    protected $prefix = null;

    protected $locale = null;

    protected $field = null;

    protected $value = null;

    public function input()
    {
        $builder = app('form');

        $options = [
            'class' => 'form-control',
        ];

        return $builder->text($this->getName(), $this->getValue(), $options);
    }

    // TODO: Change this to "elements" and have it loop through available locales
    public function element()
    {
        $config = app('config');

        //foreach ($config->get('streams::locale.available') as $locale):

        $for   = $this->getName();
        $name  = $this->getName();
        $input = $this->input();

        return view('html/partials/element', compact('for', 'name', 'input'));
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
        return $this->field;
    }

    public function getName()
    {
        return "{$this->prefix}-{$this->slug}-{$this->locale}";
    }

    public function setField($field)
    {
        $this->field = $field;

        return $this;
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
}
