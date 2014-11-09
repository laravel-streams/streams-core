<?php namespace Anomaly\Streams\Platform\Addon\FieldType\Command;

class BuildFieldTypeCommand
{

    protected $type;

    protected $field;

    protected $value;

    protected $label;

    protected $locale;

    protected $hidden;

    protected $translatable;

    protected $instructions;

    protected $placeholder;

    protected $required;

    protected $prefix;

    protected $suffix;

    protected $view;

    function __construct(
        $type,
        $field,
        $view = null,
        $value = null,
        $label = null,
        $prefix = null,
        $suffix = null,
        $locale = null,
        $hidden = false,
        $required = false,
        $placeholder = null,
        $instructions = null,
        $translatable = null
    ) {
        $this->view         = $view;
        $this->type         = $type;
        $this->field        = $field;
        $this->label        = $label;
        $this->value        = $value;
        $this->locale       = $locale;
        $this->hidden       = $hidden;
        $this->prefix       = $prefix;
        $this->suffix       = $suffix;
        $this->required     = $required;
        $this->placeholder  = $placeholder;
        $this->translatable = $translatable;
        $this->instructions = $instructions;
    }

    /**
     * @return null
     */
    public function getSuffix()
    {
        return $this->suffix;
    }

    /**
     * @return boolean
     */
    public function getHidden()
    {
        return $this->hidden;
    }

    /**
     * @return mixed
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @return null
     */
    public function getRequired()
    {
        return $this->required;
    }

    /**
     * @return mixed
     */
    public function getInstructions()
    {
        return $this->instructions;
    }

    /**
     * @return null
     */
    public function getPlaceholder()
    {
        return $this->placeholder;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return mixed
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @return mixed
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return null
     */
    public function getView()
    {
        return $this->view;
    }


    public function getTranslatable()
    {
        return $this->translatable;
    }
}
 