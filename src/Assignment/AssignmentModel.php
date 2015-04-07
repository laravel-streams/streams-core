<?php namespace Anomaly\Streams\Platform\Assignment;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Class AssignmentModel
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Assignment
 */
class AssignmentModel extends EloquentModel implements AssignmentInterface
{

    /**
     * Do not use timestamps.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The cache minutes.
     *
     * @var int
     */
    protected $cacheMinutes = 99999;

    /**
     * The foreign key for translations.
     *
     * @var string
     */
    protected $translationForeignKey = 'assignment_id';

    /**
     * Translatable attributes.
     *
     * @var array
     */
    protected $translatedAttributes = [
        'label',
        'placeholder',
        'instructions'
    ];

    /**
     * The translation model.
     *
     * @var string
     */
    protected $translationModel = 'Anomaly\Streams\Platform\Assignment\AssignmentModelTranslation';

    /**
     * The database table name.
     *
     * @var string
     */
    protected $table = 'streams_assignments';

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        self::observe(app(substr(__CLASS__, 0, -5) . 'Observer'));

        parent::boot();
    }

    /**
     * Because the assignment record holds translatable data
     * we have a conflict. The assignment table has translations
     * but not all assignment are translatable. This helps avoid
     * the translatable conflict during specific procedures.
     *
     * @param  array $attributes
     * @return static
     */
    public static function create(array $attributes)
    {
        $model = parent::create($attributes);

        $model->saveTranslations();

        return;
    }

    /**
     * Get the field slug.
     *
     * @return string
     */
    public function getFieldSlug()
    {
        $field = $this->getField();

        return $field->getSlug();
    }

    /**
     * Get the assignment's field's type.
     *
     * @return FieldType
     */
    public function getFieldType()
    {
        $field = $this->getField();
        $type  = $field->getType();

        $type->mergeRules($this->getFieldRules());
        $type->mergeConfig($this->getFieldConfig());

        $type->setRequired($this->isRequired());

        return $type;
    }

    /**
     * Get the field name.
     *
     * @return string
     */
    public function getFieldName()
    {
        $field = $this->getField();

        return $field->getName();
    }

    /**
     * Get the assignment's field's config.
     *
     * @return string
     */
    public function getFieldConfig()
    {
        $field = $this->getField();

        return $field->getConfig();
    }

    /**
     * Get the assignment's field's rules.
     *
     * @return array
     */
    public function getFieldRules()
    {
        $field = $this->getField();

        return $field->getRules();
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
     * Get the instructions.
     *
     * @return null
     */
    public function getInstructions()
    {
        return $this->instructions;
    }

    /**
     * Get the placeholder.
     *
     * @return null
     */
    public function getPlaceholder()
    {
        return $this->placeholder;
    }

    /**
     * Get the related stream.
     *
     * @return StreamInterface
     */
    public function getStream()
    {
        return $this->stream;
    }

    /**
     * Get the related field.
     *
     * @return FieldInterface
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Get the unique flag.
     *
     * @return mixed
     */
    public function isUnique()
    {
        return $this->unique;
    }

    /**
     * Get the required flag.
     *
     * @return bool
     */
    public function isRequired()
    {
        return $this->required;
    }

    /**
     * Get the translatable flag.
     *
     * @return bool
     */
    public function isTranslatable()
    {
        return $this->translatable;
    }

    /**
     * Get the column name.
     *
     * @return mixed
     */
    public function getColumnName()
    {
        $type = $this->getFieldType();

        return $type->getColumnName();
    }

    /**
     * Serialize the rules attribute
     * before setting to the model.
     *
     * @param $rules
     */
    public function setRulesAttribute($rules)
    {
        $this->attributes['rules'] = serialize((array)$rules);
    }

    /**
     * Unserialize the rules attribute
     * after getting from the model.
     *
     * @param  $rules
     * @return mixed
     */
    public function getRulesAttribute($rules)
    {
        return (array)unserialize($rules);
    }

    /**
     * @param array $items
     * @return AssignmentCollection
     */
    public function newCollection(array $items = array())
    {
        return new AssignmentCollection($items);
    }

    /**
     * Compile the assignment's stream.
     *
     * @return AssignmentInterface
     */
    public function compileStream()
    {
        $this->stream->compile();

        return $this;
    }

    /**
     * Return the stream relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stream()
    {
        return $this->belongsTo('Anomaly\Streams\Platform\Stream\StreamModel');
    }

    /**
     * Return the field relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function field()
    {
        return $this->belongsTo('Anomaly\Streams\Platform\Field\FieldModel', 'field_id');
    }
}
