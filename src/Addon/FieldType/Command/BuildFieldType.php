<?php namespace Anomaly\Streams\Platform\Addon\FieldType\Command;

/**
 * Class BuildFieldTypeCommand
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\FieldType\Command
 */
class BuildFieldTypeCommand
{

    /**
     * The field type to build.
     *
     * @var
     */
    protected $type;

    /**
     * The field slug.
     *
     * @var
     */
    protected $field;

    /**
     * The input value.
     *
     * @var null
     */
    protected $value;

    /**
     * The input label.
     *
     * @var null
     */
    protected $label;

    /**
     * The locale.
     *
     * @var null
     */
    protected $locale;

    /**
     * The hidden flag.
     *
     * @var bool
     */
    protected $hidden;

    /**
     * The translatable flag.
     *
     * @var null
     */
    protected $translatable;

    /**
     * The input instructions.
     *
     * @var null
     */
    protected $instructions;

    /**
     * The input placeholder.
     *
     * @var null
     */
    protected $placeholder;

    /**
     * The required flag.
     *
     * @var bool
     */
    protected $required;

    /**
     * The field name prefix.
     *
     * @var null
     */
    protected $prefix;

    /**
     * The field type configuration.
     *
     * @var array
     */
    protected $config;

    /**
     * The input view.
     *
     * @var null
     */
    protected $inputView;

    /**
     * The filter view.
     *
     * @var null
     */
    protected $filterView;

    /**
     * The wrapper view.
     *
     * @var null
     */
    protected $wrapperView;

    /**
     * Create a new BuildFieldTypeCommand instance.
     *
     * @param       $type
     * @param       $field
     * @param null  $value
     * @param null  $label
     * @param null  $prefix
     * @param null  $locale
     * @param bool  $hidden
     * @param bool  $required
     * @param null  $inputView
     * @param null  $filterView
     * @param null  $wrapperView
     * @param null  $placeholder
     * @param null  $instructions
     * @param null  $translatable
     * @param array $config
     */
    public function __construct(
        $type,
        $field,
        $value = null,
        $label = null,
        $prefix = null,
        $locale = null,
        $hidden = false,
        $required = false,
        $inputView = null,
        $filterView = null,
        $wrapperView = null,
        $placeholder = null,
        $instructions = null,
        $translatable = null,
        array $config = []
    ) {
        $this->type         = $type;
        $this->field        = $field;
        $this->label        = $label;
        $this->value        = $value;
        $this->locale       = $locale;
        $this->config       = $config;
        $this->hidden       = $hidden;
        $this->prefix       = $prefix;
        $this->required     = $required;
        $this->inputView    = $inputView;
        $this->filterView   = $filterView;
        $this->wrapperView  = $wrapperView;
        $this->placeholder  = $placeholder;
        $this->translatable = $translatable;
        $this->instructions = $instructions;
    }

    /**
     * Get the field type configuration.
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Get the hidden flag.
     *
     * @return boolean
     */
    public function getHidden()
    {
        return $this->hidden;
    }

    /**
     * Get the field slug.
     *
     * @return mixed
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Get the required flag.
     *
     * @return bool
     */
    public function getRequired()
    {
        return $this->required;
    }

    /**
     * Get the input instructions.
     *
     * @return mixed
     */
    public function getInstructions()
    {
        return $this->instructions;
    }

    /**
     * Get the input placeholder.
     *
     * @return string
     */
    public function getPlaceholder()
    {
        return $this->placeholder;
    }

    /**
     * Get the input label.
     *
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Get the locale.
     *
     * @return mixed
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Get the field name prefix.
     *
     * @return mixed
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Get the field type to build.
     *
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get the input value.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Get the translatable flag.
     *
     * @return bool
     */
    public function getTranslatable()
    {
        return $this->translatable;
    }


    /**
     * Get the input view.
     *
     * @return string
     */
    public function getInputView()
    {
        return $this->inputView;
    }

    /**
     * Get the filter view.
     *
     * @return string
     */
    public function getFilterView()
    {
        return $this->filterView;
    }

    /**
     * Get the wrapper view.
     *
     * @return string
     */
    public function getWrapperView()
    {
        return $this->wrapperView;
    }
}
