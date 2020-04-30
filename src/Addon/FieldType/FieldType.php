<?php

namespace Anomaly\Streams\Platform\Addon\FieldType;

use Illuminate\Database\Eloquent\Model;
use Anomaly\Streams\Platform\Addon\Addon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Anomaly\Streams\Platform\Support\Facades\Hydrator;
use Anomaly\Streams\Platform\Ui\Traits\HasClassAttribute;
use Anomaly\Streams\Platform\Ui\Traits\HasHtmlAttributes;

/**
 * Class FieldType
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class FieldType extends Addon
{
    use HasHtmlAttributes;
    use HasClassAttribute;

    use Concerns\HasRules; // Done
    use Concerns\HasValidators; // Done

    use Concerns\HasField;
    use Concerns\HasEntry;
    use Concerns\HasValue;
    use Concerns\HasPrefix;
    use Concerns\HasErrors;
    use Concerns\HasConfig;
    use Concerns\HasLocale;
    use Concerns\HasMessages;
    use Concerns\HasCastType;


    /**
     * The field label.
     *
     * @var null|string
     */
    public $label;

    /**
     * The field warning.
     *
     * @var null|string
     */
    public $warning;

    /**
     * The field placeholder.
     *
     * @var null|string
     */
    public $placeholder;

    /**
     * The field instructions.
     *
     * @var string
     */
    public $instructions;



    /**
     * The save flag.
     *
     * @var bool
     */
    public $save = true;

    /**
     * The hidden flag.
     *
     * @var bool|null
     */
    public $hidden = false;

    /**
     * The required flag.
     *
     * @var bool
     */
    public $required = false;

    /**
     * The readonly flag.
     *
     * @var bool
     */
    public $readonly = false;

    /**
     * The disabled flag.
     *
     * @var bool
     */
    public $disabled = false;

    protected $installed = true;
    protected $enabled = true;



    /**
     * The input type.
     *
     * @var string
     */
    protected $inputType = null;



    /**
     * The database column type.
     *
     * @var string
     */
    protected $columnType = 'string';

    /**
     * The database column length.
     *
     * @var null|integer
     */
    protected $columnLength = null;



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
    protected $presenter = FieldTypePresenter::class;

    /**
     * The schema class.
     *
     * @var null|string
     */
    protected $schema = FieldTypeSchema::class;



    /**
     * The query class.
     *
     * @var null|string
     */
    protected $query = null;

    /**
     * The field type criteria.
     *
     * @var null|string
     */
    protected $criteria;



    /**
     * Get the post value.
     *
     * @param  null $default
     * @return mixed
     */
    public function getPostValue($default = null)
    {
        $value = request()->post($this->getInputName(), $default);

        if ($value == '') {
            $value = null;
        }

        return $value;
    }

    /**
     * Get the value for repopulating
     * field after failed validation.
     *
     * @param  null $default
     * @return mixed
     */
    public function getRepopulateValue($default = null)
    {
        return $this->getPostValue($default);
    }

    /**
     * Return if any posted input exists.
     *
     * @return bool
     */
    public function hasPostedInput()
    {
        return request()->has(str_replace('.', '_', $this->getInputName()));
    }

    /**
     * Get the value to index.
     *
     * @return string
     */
    public function getSearchableValue()
    {
        $value = $this->getValue();

        if ($value instanceof Relation) {
            $value = $value->getResults();
        }

        if ($value instanceof Model) {
            $value = $value->toArray();
        }

        if (is_array($value)) {
            $value = json_encode($value);
        }

        return (string) $value;
    }

    /**
     * Get the value to validate.
     *
     * @param  null $default
     * @return mixed
     */
    public function getValidationValue($default = null)
    {
        $value = $this->getPostValue($default);

        if (is_array($value)) {
            array_filter($value) ?: $default;
        }

        return $value;
    }

    /**
     * Get the input value.
     *
     * @param  null $default
     * @return mixed
     */
    public function getInputValue($default = null)
    {
        return $this->getPostValue($default);
    }

    /**
     * Get the attributes.
     *
     * @param array $attributes
     * @return array
     */
    public function attributes(array $attributes = [])
    {
        return array_filter(
            array_merge(
                [
                    'value'       => $this->getValue(),
                    'name'        => $this->getInputName(),
                    'placeholder' => $this->placeholder,

                    'readonly' => $this->readonly ? 'readonly' : '',
                    'disabled' => $this->disabled ? 'disabled' : '',

                    'data-field'      => $this->getField(),
                    'data-field_name' => $this->getFieldName(),
                    'data-provides'   => $this->getNamespace(),

                    'class'           => $this->getClass() ?: 'input',
                    'id'              => $this->getInputName(),
                ],
                $this->getAttributes(),
                $attributes
            )
        );
    }

    /**
     * Get the attributes.
     *
     * @return array
     */
    public function wrapperAttributes()
    {
        $class = 'field';

        if ($this->hasErrors()) {
            $class .= ' -error';
        }

        $class .= " {$this->getFieldName()}-field";
        $class .= " {$this->getSlug()}-field_tye";

        if ($this->hidden) {
            $class .= " hidden";
        }

        return [
            'class' => $class,
        ];
    }


    /**
     * Get the name of the input.
     *
     * @return string
     */
    public function getInputName()
    {
        $suffix = $this->locale ? '_' . $this->locale : null;

        return "{$this->getPrefix()}{$this->getField()}{$suffix}";
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
     * Get the column name.
     *
     * @return string
     */
    public function getUniqueColumnName()
    {
        return $this->getColumnName();
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
     * Get the column length.
     *
     * @return string
     */
    public function getColumnLength()
    {
        return $this->columnLength;
    }

    /**
     * Get the input type.
     *
     * @return string
     */
    public function getInputType()
    {
        return $this->inputType;
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
     * @param  array $payload
     * @return string
     */
    public function render($payload = [])
    {
        return view(
            $this->getWrapperView(),
            array_merge(
                $payload,
                [
                    'fieldType' => $this,
                ]
            )
        )->render();
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
     * Return a new presenter instance.
     *
     * @return FieldTypePresenter
     */
    public function newPresenter()
    {
        if (!$this->presenter) {
            $this->presenter = get_class($this) . 'Presenter';
        }

        if (!class_exists($this->presenter)) {
            $this->presenter = FieldTypePresenter::class;
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
     * Get the schema.
     *
     * @return string
     */
    public function getSchema()
    {
        return $this->schema;
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
            $this->query = FieldTypeQuery::class;
        }

        return app()->make($this->query, ['fieldType' => $this]);
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
     * Get the criteria.
     *
     * @param Builder $query
     * @return FieldTypeQuery
     */
    public function criteria(Builder $query)
    {
        if (!$this->criteria) {
            $this->criteria = get_class($this) . 'Criteria';
        }

        if (!class_exists($this->criteria)) {
            $this->criteria = FieldTypeCriteria::class;
        }

        return app()->make(
            $this->criteria,
            [
                'fieldType' => $this,
                'query'     => $query,
            ]
        );
    }

    /**
     * Set the criteria class.
     *
     * @param $criteria
     * @return $this
     */
    public function setCriteria($criteria)
    {
        $this->criteria = $criteria;

        return $this;
    }

    /**
     * Render the input.
     *
     * @param array $payload
     * @return string
     */
    public function getInput(array $payload = [])
    {
        return view(
            $this->getInputView(),
            array_merge($payload, ['fieldType' => decorate($this)])
        )->render();
    }

    /**
     * Render the filter.
     *
     * @param array $payload
     * @return string
     */
    public function getFilter(array $payload = [])
    {
        return view(
            $this->getFilterView(),
            array_merge($payload, ['fieldType' => decorate($this)])
        )->render();
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return array_merge(Hydrator::dehydrate($this), [
            'attributes' => $this->attributes(),
        ]);
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int  $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    /**
     * Return the rendering.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }
}
