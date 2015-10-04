<?php namespace Anomaly\Streams\Platform\Addon\FieldType;

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Model\EloquentModel;
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
     * The disabled flag.
     *
     * @var bool
     */
    protected $disabled = false;

    /**
     * The readonly flag.
     *
     * @var bool
     */
    protected $readonly = false;

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
     * Custom validation messages.
     * i.e. 'rule' => ['rule', 'message']
     *
     * @var array
     */
    protected $messages = [];

    /**
     * Configuration options.
     *
     * @var array
     */
    protected $config = [];

    /**
     * The entry in context.
     *
     * @var null|EntryInterface|EloquentModel
     */
    protected $entry = null;

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
     * The field placeholder.
     *
     * @var null
     */
    protected $placeholder = null;

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
     * The field type class.
     *
     * @var null|string
     */
    protected $class = null;

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
    protected $inputView = 'streams::form/partials/input';

    /**
     * The field's filter input view.
     *
     * @var string
     */
    protected $filterView = 'streams::form/partials/filter';

    /**
     * The field wrapper view.
     *
     * @var string
     */
    protected $wrapperView = 'streams::form/partials/wrapper';

    /**
     * The presenter class.
     *
     * @var null|string
     */
    protected $presenter = null;

    /**
     * The modifier class.
     *
     * @var null|string
     */
    protected $modifier = null;

    /**
     * The accessor class.
     *
     * @var null|string
     */
    protected $accessor = null;

    /**
     * The schema class.
     *
     * @var null|string
     */
    protected $schema = null;

    /**
     * The query class.
     *
     * @var null|string
     */
    protected $query = null;

    /**
     * Return a config value.
     *
     * @param      $key
     * @param null $default
     * @return mixed
     */
    public function config($key, $default = null)
    {
        return array_get($this->getConfig(), $key, $default);
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
     * Get the readonly flag.
     *
     * @return bool
     */
    public function isReadonly()
    {
        return $this->readonly;
    }

    /**
     * Set the readonly flag.
     *
     * @param $readonly
     * @return $this
     */
    public function setReadonly($readonly)
    {
        $this->readonly = $readonly;

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
     * @return $this
     */
    public function mergeRules(array $rules)
    {
        $this->rules = array_unique(array_merge($this->rules, $rules));

        return $this;
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
     * @return $this
     */
    public function mergeValidators(array $validators)
    {
        $this->validators = array_merge($this->validators, $validators);

        return $this;
    }

    /**
     * Get the messages.
     *
     * @return array
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * Merge messages.
     *
     * @param array $messages
     * @return $this
     */
    public function mergeMessages(array $messages)
    {
        $this->messages = array_merge($this->messages, $messages);

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
     * Merge configuration.
     *
     * @param array $config
     * @return $this
     */
    public function mergeConfig(array $config)
    {
        $this->config = array_merge($this->config, $config);

        return $this;
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
     * Get a config value.
     *
     * @param      $key
     * @param null $default
     * @return mixed
     */
    public function configGet($key, $default = null)
    {
        return array_get($this->config, $key, $default);
    }

    /**
     * Set a config value.
     *
     * @param $key
     * @param $value
     * @return $this
     */
    public function configSet($key, $value)
    {
        array_set($this->config, $key, $value);

        return $this;
    }

    /**
     * Get the entry.
     *
     * @return EntryInterface|EloquentModel
     */
    public function getEntry()
    {
        return $this->entry;
    }

    /**
     * Set the entry.
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
     * Get the post value.
     *
     * @param null $default
     * @return mixed
     */
    public function getPostValue($default = null)
    {
        $value = array_get($_POST, str_replace('.', '_', $this->getInputName()), $default);

        if ($value == '') {
            $value = null;
        }

        return $value;
    }

    /**
     * Get the value to validate.
     *
     * @param null $default
     * @return mixed
     */
    public function getValidationValue($default = null)
    {
        return $this->getPostValue($default);
    }

    /**
     * Get the input value.
     *
     * @param null $default
     * @return mixed
     */
    public function getInputValue($default = null)
    {
        return $this->getPostValue($default);
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
     * Get the placeholder.
     *
     * @return null|string
     */
    public function getPlaceholder()
    {
        return $this->placeholder;
    }

    /**
     * Set the placeholder.
     *
     * @param $placeholder
     * @return $this
     */
    public function setPlaceholder($placeholder)
    {
        $this->placeholder = $placeholder;

        return $this;
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
     * Get the suffix.
     *
     * @return null|string
     */
    public function getSuffix()
    {
        return $this->locale ? '_' . $this->locale : null;
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
     * Get the class.
     *
     * @return null|string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Set the class.
     *
     * @param $class
     * @return $this
     */
    public function setClass($class)
    {
        $this->class = $class;

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
     * Get the field name. This is the field
     * with the leading form suffix.
     *
     * @return string
     */
    public function getFieldName()
    {
        return "{$this->getPrefix()}{$this->getField()}";
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
     * Render the input and wrapper.
     *
     * @return string
     */
    public function render()
    {
        return view($this->getWrapperView(), ['field_type' => $this])->render();
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
        return $this->filterView;
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

        return app()->make($this->presenter, ['object' => $this]);
    }

    /**
     * Set the presenter class.
     *
     * @param $presenter
     * @return $this
     */
    public function setPresenter($presenter)
    {
        $this->presenter = $presenter;

        return $this;
    }

    /**
     * Get the modifier.
     *
     * @return FieldTypeModifier
     */
    public function getModifier()
    {
        /* @var FieldTypeModifier $modifier */
        if (is_object($modifier = $this->modifier)) {
            return $modifier->setFieldType($this);
        }

        if (!$this->modifier) {
            $this->modifier = get_class($this) . 'Modifier';
        }

        if (!class_exists($this->modifier)) {
            $this->modifier = 'Anomaly\Streams\Platform\Addon\FieldType\FieldTypeModifier';
        }

        $modifier = app()->make($this->modifier);

        $modifier->setFieldType($this);

        return $this->modifier = $modifier;
    }

    /**
     * Get the accessor.
     *
     * @return FieldTypeAccessor
     */
    public function getAccessor()
    {
        /* @var FieldTypeAccessor $accessor */
        if (is_object($accessor = $this->accessor)) {
            return $accessor->setFieldType($this);
        }

        if (!$this->accessor) {
            $this->accessor = get_class($this) . 'Accessor';
        }

        if (!class_exists($this->accessor)) {
            $this->accessor = 'Anomaly\Streams\Platform\Addon\FieldType\FieldTypeAccessor';
        }

        $accessor = app()->make($this->accessor);

        $accessor->setFieldType($this);

        return $this->accessor = $accessor;
    }

    /**
     * Set the accessor.
     *
     * @param $accessor
     * @return $this
     */
    public function setAccessor($accessor)
    {
        $this->accessor = $accessor;

        return $this;
    }

    /**
     * Get the schema.
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

        return app()->make($this->schema, ['fieldType' => $this]);
    }

    /**
     * Set the schema.
     *
     * @param $schema
     * @return $this
     */
    public function setSchema($schema)
    {
        $this->schema = $schema;

        return $this;
    }

    /**
     * Get the query utility.
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
     * Set the query class.
     *
     * @param $query
     * @return $this
     */
    public function setQuery($query)
    {
        $this->query = $query;

        return $this;
    }

    /**
     * Render the input.
     *
     * @return string
     */
    public function getInput()
    {
        return view($this->getInputView(), ['field_type' => $this])->render();
    }

    /**
     * Render the filter.
     *
     * @return string
     */
    public function getFilter()
    {
        return view($this->getFilterView(), ['field_type' => $this])->render();
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

    /**
     * Return the rendering.
     *
     * @return string
     */
    function __toString()
    {
        return $this->render();
    }
}
