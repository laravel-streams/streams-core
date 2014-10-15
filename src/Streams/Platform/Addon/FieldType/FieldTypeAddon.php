<?php namespace Streams\Platform\Addon\FieldType;

use Streams\Platform\Addon\Addon;

class FieldTypeAddon extends Addon
{
    /**
     * @var null
     */
    protected $slug = null;

    /**
     * @var string
     */
    protected $type = 'field_type';

    /**
     * @var string
     */
    protected $columnType = 'string';

    /**
     * @var null
     */
    protected $prefix = null;

    /**
     * @var null
     */
    protected $locale = null;

    /**
     * @var null
     */
    protected $field = null;

    /**
     * @var null
     */
    protected $value = null;

    /**
     * @return mixed
     */
    public function input()
    {
        $builder = app('form');

        $options = [
            'class' => 'form-control',
        ];

        return $builder->text($this->getName(), $this->getValue(), $options);
    }

    /**
     * TODO: Change this to "elements" and have it loop through available locales
     * @return mixed
     */
    public function element()
    {
        $config = app('config');

        //foreach ($config->get('streams::locale.available') as $locale):

        $for   = $this->getName();
        $name  = $this->getName();
        $input = $this->input();

        return view('html/partials/element', compact('for', 'name', 'input'));
    }

    /**
     * @param $value
     * @return mixed
     */
    public function mutate($value)
    {
        return $value;
    }

    /**
     * @return string
     */
    public function getColumnType()
    {
        return $this->columnType;
    }

    /**
     * @return null
     */
    public function getColumnName()
    {
        return $this->field;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return "{$this->prefix}-{$this->slug}-{$this->locale}";
    }

    /**
     * @param null $field
     * return $this
     */
    public function setField($field)
    {
        $this->field = $field;

        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return null
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return FieldTypePresenter
     */
    public function newPresenter()
    {
        return new FieldTypePresenter($this);
    }

    /**
     * @return FieldTypeServiceProvider
     */
    public function newServiceProvider()
    {
        return new FieldTypeServiceProvider($this->app);
    }
}
