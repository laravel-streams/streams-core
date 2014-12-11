<?php namespace Anomaly\Streams\Platform\Addon\FieldType;

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Contract\PresentableInterface;
use Anomaly\Streams\Platform\Ui\Table\Table;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class FieldType
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\FieldType
 */
class FieldType extends Addon implements PresentableInterface
{

    /**
     * Validation rules.
     *
     * @var array
     */
    protected $rules = [];

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
     * The field's input class.
     *
     * @var null
     */
    protected $class = 'form-control';

    /**
     * The field's input locale.
     *
     * @var null
     */
    protected $locale = null;

    /**
     * The field's input placeholder.
     *
     * @var null
     */
    protected $placeholder = null;

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
     * @var string
     */
    protected $prefix = '';

    /**
     * The field's input suffix.
     *
     * @var string
     */
    protected $suffix = '';

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
    protected $inputView = 'ui/form/partials/input';

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
    protected $wrapperView = 'ui/form/partials/wrapper';

    /**
     * Return a new instance of the field type.
     *
     * @return static
     */
    public function newInstance()
    {
        return new static;
    }

    /**
     * Get data for the input view.
     *
     * @return array
     */
    public function getInputData()
    {
        $value       = $this->getValue();
        $class       = $this->getClass();
        $name        = $this->getFieldName();
        $type        = $this->getConfig('type', 'text');
        $placeholder = trans($this->getPlaceholder(), [], null, $this->getLocale());

        return compact('name', 'value', 'type', 'class', 'placeholder');
    }

    /**
     * Get data for the filter input view.
     *
     * @return array
     */
    public function getFilterData()
    {
        return $this->getInputData();
    }

    /**
     * Get data for the field wrapper.
     *
     * @return array
     */
    public function getWrapperData()
    {
        $locale       = $this->getLocale();
        $hidden       = $this->getHidden();
        $required     = $this->getRequired();
        $translatable = $this->getTranslatable();

        $language     = trans("language.{$locale}");
        $label        = trans($this->getLabel(), [], null, $locale);
        $instructions = trans($this->getInstructions(), [], null, $locale);

        $input = view($this->getInputView(), $this->getInputData());

        return compact(
            'input',
            'label',
            'class',
            'hidden',
            'locale',
            'language',
            'required',
            'instructions',
            'translatable'
        );
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
     * Set the config options.
     *
     * @param array $config
     * @return $this
     */
    public function setConfig(array $config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Put a config value.
     *
     * @param $key
     * @param $value
     * @return $this
     */
    public function putConfig($key, $value)
    {
        $this->config[$key] = $value;

        return $this;
    }

    /**
     * Pull a config value.
     *
     * @param      $key
     * @param null $default
     * @return mixed
     */
    public function pullConfig($key, $default = null)
    {
        return array_get($this->config, $key, $default);
    }

    /**
     * Get config.
     *
     * @return array|null
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Set the field slug.
     *
     * @param $field
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
     * @param $value
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
     * @return null
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the label.
     *
     * @param $label
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
     * @return null
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set the input class.
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
     * Get the input class.
     *
     * @return null
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Set the instructions.
     *
     * @param $instructions
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
     * @return null
     */
    public function getInstructions()
    {
        return $this->instructions;
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
     * Get the placeholder.
     *
     * @return null
     */
    protected function getPlaceholder()
    {
        return $this->placeholder;
    }

    /**
     * Set the locale.
     *
     * @param $locale
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
     * @return mixed|null
     */
    private function getLocale()
    {
        if (!$this->locale) {

            $this->locale = config('app.locale', 'en');
        }

        return $this->locale;
    }

    /**
     * Set the translatable flag.
     *
     * @param $translatable
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
    public function getTranslatable()
    {
        return ($this->translatable);
    }

    /**
     * Ste the prefix.
     *
     * @param null $prefix
     * @return $this
     */
    public function setPrefix($prefix = null)
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
        if ($this->prefix) {

            return $this->prefix . (ends_with($this->prefix, '_') ? null : '_');
        }

        return $this->prefix;
    }

    /**
     * Set the suffix.
     *
     * @param null $suffix
     * @return $this
     */
    public function setSuffix($suffix = null)
    {
        $this->suffix = $suffix;

        return $this;
    }

    /**
     * Get the suffix.
     *
     * @return null|string
     */
    public function getSuffix()
    {
        if ($this->suffix) {

            return (starts_with($this->suffix, '_') ? null : '_') . $this->suffix;
        }

        return null;
    }

    /**
     * Set the hidden flag.
     *
     * @param $hidden
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
    public function getHidden()
    {
        return ($this->hidden);
    }

    /**
     * Set the required flag.
     *
     * @param $required
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
    public function getRequired()
    {
        return ($this->required);
    }

    /**
     * Get the field name.
     *
     * @return string
     */
    public function getFieldName()
    {
        return "{$this->getPrefix()}{$this->getField()}{$this->getSuffix()}";
    }

    /**
     * Get the column name.
     *
     * @return null
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
     * @param $view
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
     * @param $view
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
        return $this->filterView ? : $this->inputView;
    }

    /**
     * Set the wrapper view.
     *
     * @param $view
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
     * Set the attribute on the model's attributes array.
     *
     * @param $attributes
     * @param $value
     * @return mixed
     */
    public function setAttribute(&$attributes, $value)
    {
        // $attributes[$this->getColumnName()] = $value;
        // return true;
    }

    /**
     * Mutate a value before setting on the model.
     *
     * @param $value
     * @return mixed
     */
    public function mutate($value)
    {
        return $value;
    }

    /**
     * Unmutate a value from the model.
     *
     * @param $value
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
        return view($this->getWrapperView(), $this->getWrapperData());
    }

    /**
     * Render the input.
     *
     * @return \Illuminate\View\View
     */
    public function renderInput()
    {
        return view($this->getInputView(), $this->getInputData());
    }

    /**
     * Render the filter.
     *
     * @return \Illuminate\View\View
     */
    public function renderFilter()
    {
        return view($this->getFilterView(), $this->getFilterData());
    }

    /**
     * Filter a query by the value of a
     * field using this field type.
     *
     * @param Builder $query
     * @param         $value
     */
    public function filter(Builder $query, $value)
    {
        $query = $query->where($this->getColumnName(), 'LIKE', "%{$value}%");
    }

    /**
     * Order a query in the given direction
     * by a field using this field type.
     *
     * @param Table $table
     * @param       $direction
     * @return mixed
     */
    public function orderBy(Table $table, $direction)
    {
        return $table->setOrderBy([$this->getColumnName() => $direction]);
    }

    /**
     * Return the relation from the compiled model. This
     * is where you would modify the relation if needed.
     *
     * @param Builder $relation
     * @return Builder
     */
    public function relation(Builder $relation)
    {
        return $relation;
    }

    /**
     * Return a new presenter object.
     *
     * @return mixed
     */
    public function newPresenter()
    {
        $presenter = get_class($this) . 'Presenter';

        if (!class_exists($presenter)) {

            $presenter = '\Anomaly\Streams\Platform\Addon\FieldType\FieldTypePresenter';
        }

        return app()->make($presenter, [$this]);
    }


    /**
     * Represent Eloquent's hasOne method.
     *
     * @param      $related
     * @param null $foreignKey
     * @param null $localKey
     * @return array
     */
    public function hasOne($related, $foreignKey = null, $localKey = null)
    {
        return array(
            'method'    => __FUNCTION__,
            'arguments' => func_get_args(),
        );
    }

    /**
     * Represent Eloquent's morphOne method.
     *
     * @param      $related
     * @param      $name
     * @param null $type
     * @param null $id
     * @param null $localKey
     * @return array
     */
    public function morphOne($related, $name, $type = null, $id = null, $localKey = null)
    {
        return array(
            'method'    => __FUNCTION__,
            'arguments' => func_get_args(),
        );
    }

    /**
     * Represent Eloquent's belongsTo method.
     *
     * @param      $related
     * @param null $foreignKey
     * @return array
     */
    public function belongsTo($related, $foreignKey = null)
    {
        return array(
            'method'    => __FUNCTION__,
            'arguments' => func_get_args(),
        );
    }

    /**
     * Represent Eloquent's morphTo method.
     *
     * @param null $name
     * @param null $type
     * @param null $id
     * @return array
     */
    public function morphTo($name = null, $type = null, $id = null)
    {
        return array(
            'method'    => __FUNCTION__,
            'arguments' => func_get_args(),
        );
    }

    /**
     * Represent Eloquent's hasMany method.
     *
     * @param      $related
     * @param null $foreignKey
     * @return array
     */
    public function hasMany($related, $foreignKey = null)
    {
        return array(
            'method'    => __FUNCTION__,
            'arguments' => func_get_args(),
        );
    }

    /**
     * Represent Eloquent's morphMany method.
     *
     * @param      $related
     * @param      $name
     * @param null $type
     * @param null $id
     * @param null $localKey
     * @return array
     */
    public function morphMany($related, $name, $type = null, $id = null, $localKey = null)
    {
        return array(
            'method'    => __FUNCTION__,
            'arguments' => func_get_args(),
        );
    }

    /**
     * Represent Eloquent's belongsToMany method.
     *
     * @param      $related
     * @param null $table
     * @param null $foreignKey
     * @param null $otherKey
     * @return array
     */
    public function belongsToMany($related, $table = null, $foreignKey = null, $otherKey = null)
    {
        return array(
            'method'    => __FUNCTION__,
            'arguments' => func_get_args(),
        );
    }

    /**
     * Represent Eloquent's morphToMany method.
     *
     * @param      $related
     * @param      $name
     * @param null $table
     * @param null $foreignKey
     * @param null $otherKey
     * @param bool $inverse
     * @return array
     */
    public function morphToMany($related, $name, $table = null, $foreignKey = null, $otherKey = null, $inverse = false)
    {
        return array(
            'method'    => __FUNCTION__,
            'arguments' => func_get_args(),
        );
    }
}
