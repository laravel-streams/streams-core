<?php namespace Streams\Platform\Addon\FieldType;

use Streams\Platform\Addon\Addon;
use Streams\Platform\Contract\PresentableInterface;

class FieldTypeAddon extends Addon implements PresentableInterface
{
    protected $slug = null;

    protected $value = null;

    protected $label = null;

    protected $instructions = null;

    protected $locale = null;

    protected $prefix = 'default';

    protected $columnType = 'string';

    public function input()
    {
        $builder = app('form');

        $options = [
            'class' => 'form-control',
        ];

        return $builder->text($this->getFieldName(), $this->getValue(), $options);
    }

    public function element()
    {
        $id = $this->getFieldName();

        $label        = trans($this->label);
        $instructions = trans($this->instructions);
        $language     = trans("language.{$this->locale}");

        $input = $this->input();

        $data = compact('id', 'label', 'language', 'instructions', 'input');

        return view('html/partials/element', $data);
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;

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

    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    public function setInstructions($instructions)
    {
        $this->instructions = $instructions;

        return $this;
    }

    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    public function getFieldName()
    {
        return "{$this->prefix}-{$this->slug}-{$this->locale}";
    }

    public function getColumnName()
    {
        return $this->slug;
    }

    public function getColumnType()
    {
        return $this->columnType;
    }

    public function newPresenter()
    {
        return new FieldTypePresenter($this);
    }
}
