<?php namespace Anomaly\Streams\Platform\Addon\FieldType;

use Anomaly\Streams\Platform\Addon\Addon;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class FieldType
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\FieldType
 */
class FieldType extends Addon
{

    /**
     * The deferred flag. Deferred field
     * types will not be processed until
     * after the entry is saved.
     *
     * @var bool
     */
    protected $deferred = false;

    /**
     * The disabled flag.
     *
     * @var bool
     */
    protected $disabled = false;

    /**
     * Validation rules.
     *
     * @var array
     */
    protected $rules = [];

    /**
     * Custom validators.
     * i.e. 'rule' => ['message', 'handler']
     *
     * @var array
     */
    protected $validators = [];

    /**
     * Configuration options.
     *
     * @var array
     */
    protected $config = [];

    /**
     * The field slug.
     *
     * @var null
     */
    protected $field = null;

    /**
     * The field value.
     *
     * @var null
     */
    protected $value = null;

    /**
     * The field label.
     *
     * @var null
     */
    protected $label = null;

    /**
     * The field's input locale.
     *
     * @var null
     */
    protected $locale = null;

    /**
     * The field instructions.
     *
     * @var null
     */
    protected $instructions = null;

    /**
     * Is the field translatable?
     *
     * @var bool
     */
    protected $translatable = false;

    /**
     * Is the field required?
     *
     * @var bool
     */
    protected $required = false;

    /**
     * Is the field hidden?
     *
     * @var bool
     */
    protected $hidden = false;

    /**
     * The field's input prefix.
     *
     * @var null|string
     */
    protected $prefix = null;

    /**
     * The field's input prefix.
     *
     * @var null|string
     */
    protected $suffix = null;

    /**
     * The database column type.
     *
     * @var string
     */
    protected $columnType = 'string';

    /**
     * The field input view.
     *
     * @var string
     */
    protected $inputView = 'streams::ui/form/partials/input';

    /**
     * The field's filter input view.
     *
     * @var string
     */
    protected $filterView = null;

    /**
     * The field wrapper view.
     *
     * @var string
     */
    protected $wrapperView = 'streams::ui/form/partials/wrapper';

    /**
     * The field type presenter.
     *
     * @var null|string
     */
    protected $presenter = null;

    /**
     * The field type modification handler.
     *
     * @var null|string
     */
    protected $modifier = null;

    /**
     * The field type handler.
     *
     * @var null|string
     */
    protected $handler = null;

    /**
     * The field type schema handler.
     *
     * @var null|string
     */
    protected $schema = null;

    /**
     * The field type query handler.
     *
     * @var null|string
     */
    protected $query = null;

    /**
     * Get the deferred flag.
     *
     * @return bool
     */
    public function isDeferred()
    {
        return $this->deferred;
    }

    /**
     * Get the disabled flag.
     *
     * @return bool
     */
    public function isDisabled()
    {
        return $this->disabled;
    }

    /**
     * Set the disabled flag.
     *
     * @param $disabled
     * @return $this
     */
    public function setDisabled($disabled)
    {
        $this->disabled = $disabled;

        return $this;
    }

    /**
     * Get the rules.
     *
     * @return array
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * Merge rules.
     *
     * @param array $rules
     */
    public function mergeRules(array $rules)
    {
        $this->rules = array_unique($this->rules + $rules);
    }

    /**
     * Get the validators.
     *
     * @return array
     */
    public function getValidators()
    {
        return $this->validators;
    }

    /**
     * Merge validators.
     *
     * @param array $validators
     */
    public function mergeValidators(array $validators)
    {
        $this->validators = array_unique($this->validators + $validators);
    }

    /**
     * @param $config
     * @return $this
     */
    public function setConfig(array $config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Get the config options.
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Set the field slug.
     *
     * @param  $field
     * @return $this
     */
    public function setField($field)
    {
        $this->field = $field;

        return $this;
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
     * Set the value.
     *
     * @param  $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get the value.
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the label.
     *
     * @param  $label
     * @return $this
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get the label.
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set the instructions.
     *
     * @param  $instructions
     * @return $this
     */
    public function setInstructions($instructions)
    {
        $this->instructions = $instructions;

        return $this;
    }

    /**
     * Get the instructions.
     *
     * @return string
     */
    public function getInstructions()
    {
        return $this->instructions;
    }

    /**
     * Set the locale.
     *
     * @param  $locale
     * @return $this
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Get the locale.
     *
     * @return null|string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Set the translatable flag.
     *
     * @param  $translatable
     * @return $this
     */
    public function setTranslatable($translatable)
    {
        $this->translatable = $translatable;

        return $this;
    }

    /**
     * Get the translatable flag.
     *
     * @return bool
     */
    public function isTranslatable()
    {
        return ($this->translatable);
    }

    /**
     * Set the prefix.
     *
     * @param  $prefix
     * @return $this
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Get the prefix.
     *
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Get the suffix.
     *
     * @return null|string
     */
    public function getSuffix()
    {
        return $this->suffix;
    }

    /**
     * Set the suffix.
     *
     * @param  $suffix
     * @return $this
     */
    public function setSuffix($suffix)
    {
        $this->suffix = $suffix;

        return $this;
    }

    /**
     * Set the hidden flag.
     *
     * @param  $hidden
     * @return $this
     */
    public function setHidden($hidden)
    {
        $this->hidden = ($hidden);

        return $this;
    }

    /**
     * Get the hidden flag.
     *
     * @return bool
     */
    public function isHidden()
    {
        return ($this->hidden);
    }

    /**
     * Set the required flag.
     *
     * @param  $required
     * @return $this
     */
    public function setRequired($required)
    {
        $this->required = $required;

        return $this;
    }

    /**
     * Get the required flag.
     *
     * @return bool
     */
    public function isRequired()
    {
        return ($this->required);
    }

    /**
     * Get the name of the input.
     *
     * @return string
     */
    public function getInputName()
    {
        return "{$this->getPrefix()}{$this->getField()}{$this->getSuffix()}";
    }

    /**
     * Get the column name.
     *
     * @return string
     */
    public function getColumnName()
    {
        return $this->field;
    }

    /**
     * Get the column type.
     *
     * @return string
     */
    public function getColumnType()
    {
        return $this->columnType;
    }

    /**
     * Set the input view.
     *
     * @param  $view
     * @return $this
     */
    public function setInputView($view)
    {
        $this->inputView = $view;

        return $this;
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
     * Set the filter view.
     *
     * @param  $view
     * @return $this
     */
    public function setFilterView($view)
    {
        $this->filterView = $view;

        return $this;
    }

    /**
     * Get the filter view.
     *
     * @return string
     */
    public function getFilterView()
    {
        return $this->filterView ?: $this->inputView;
    }

    /**
     * Set the wrapper view.
     *
     * @param  $view
     * @return $this
     */
    public function setWrapperView($view)
    {
        $this->wrapperView = $view;

        return $this;
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

    /**
     * Get the presenter.
     *
     * @return FieldTypePresenter
     */
    public function getPresenter()
    {
        if (!$this->presenter) {
            $this->presenter = get_class($this) . 'Presenter';
        }

        if (!class_exists($this->presenter)) {
            $this->presenter = 'Anomaly\Streams\Platform\Addon\FieldType\FieldTypePresenter';
        }

        return app()->make($this->presenter, [$this]);
    }

    /**
     * Get the modifier.
     *
     * @return FieldTypeModifier
     */
    public function getModifier()
    {
        if (!$this->modifier) {
            $this->modifier = get_class($this) . 'Modifier';
        }

        if (!class_exists($this->modifier)) {
            $this->modifier = 'Anomaly\Streams\Platform\Addon\FieldType\FieldTypeModifier';
        }

        return app()->make($this->modifier, [$this]);
    }

    /**
     * Get the handler.
     *
     * @return FieldTypeHandler
     */
    public function getHandler()
    {
        if (!$this->handler) {
            $this->handler = get_class($this) . 'Handler';
        }

        if (!class_exists($this->handler)) {
            $this->handler = 'Anomaly\Streams\Platform\Addon\FieldType\FieldTypeHandler';
        }

        return app()->make($this->handler, [$this]);
    }

    /**
     * Get the field type schema handler.
     *
     * @return FieldTypeSchema
     */
    public function getSchema()
    {
        if (!$this->schema) {
            $this->schema = get_class($this) . 'Schema';
        }

        if (!class_exists($this->schema)) {
            $this->schema = 'Anomaly\Streams\Platform\Addon\FieldType\FieldTypeSchema';
        }

        return app()->make($this->schema, [$this]);
    }

    /**
     * Get the field type query handler.
     *
     * @return FieldTypeQuery
     */
    public function getQuery()
    {
        if (!$this->query) {
            $this->query = get_class($this) . 'Query';
        }

        if (!class_exists($this->query)) {
            $this->query = 'Anomaly\Streams\Platform\Addon\FieldType\FieldTypeQuery';
        }

        return app()->make($this->query, [$this]);
    }

    /**
     * Set the attribute on the model's attributes array.
     *
     * @param  $attributes
     * @param  $value
     * @return mixed
     */
    public function setAttribute(&$attributes, $value)
    {
    }

    /**
     * Mutate a value before setting on the model.
     *
     * @param  $value
     * @return mixed
     */
    public function mutate($value)
    {
        return $value;
    }

    /**
     * Unmutate a value from the model.
     *
     * @param  $value
     * @return mixed
     */
    public function unmutate($value)
    {
        return $value;
    }

    /**
     * Render the input and wrapper.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view($this->getWrapperView(), ['field_type' => $this]);
    }

    /**
     * Render the input.
     *
     * @return \Illuminate\View\View
     */
    public function renderInput()
    {
        return view($this->getInputView(), ['field_type' => $this]);
    }

    /**
     * Render the filter.
     *
     * @return \Illuminate\View\View
     */
    public function renderFilter()
    {
        return view($this->getFilterView(), ['field_type' => $this]);
    }

    /**
     * Return the relation from the compiled model. This
     * is where you would modify the relation if needed.
     *
     * @param  Builder $relation
     * @return Builder
     */
    public function relation(Builder $relation)
    {
        return $relation;
    }
}
