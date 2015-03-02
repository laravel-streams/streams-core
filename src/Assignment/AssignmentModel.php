<?php namespace Anomaly\Streams\Platform\Assignment;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
use Anomaly\Streams\Platform\Model\EloquentModel;

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
     * The foreign key for translations.
     *
     * @var string
     */
    protected $translationForeignKey = 'assignment_id';

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
        self::observe(app('Anomaly\Streams\Platform\Assignment\AssignmentObserver'));

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
     * @return mixed
     */
    public function getFieldSlug()
    {
        return $this->field->slug;
    }

    /**
     * Get the assignment's field's type.
     *
     * @return FieldType
     */
    public function getFieldType($locale = null)
    {
        // Get the type object from our related field.
        $field = $this->getField();

        $type = $field->getType();

        // These are always on or off so set em.
        $type->setRequired($this->isRequired());
        $type->setTranslatable($this->isTranslatable());

        if ($label = $this->getLabel($locale)) {
            $type->setLabel($label);
        }

        if ($instructions = $this->getInstructions($locale)) {
            $type->setInstructions($instructions);
        }

        if ($placeholder = $this->getPlaceholder($locale)) {
            $type->setPlaceholder($placeholder);
        }

        return $type;
    }

    /**
     * Get the field name.
     *
     * @param null $locale
     * @return string
     */
    public function getFieldName($locale = null)
    {
        return $this->getField()->getName($locale);
    }

    /**
     * Get the label. If it is not translated then
     * then just return null instead.
     *
     * @param  null $locale
     * @return string|null
     */
    public function getLabel($locale = null)
    {
        $label = $this->translateOrDefault($locale)->label;

        if (str_is($label, '*.*.*::*.*.*') && trans()->has($label)) {
            return $this->translateOrDefault($locale)->label;
        }

        return $this->getFieldName($locale);
    }

    /**
     * Get the instructions. If it is not translated
     * then just return null instead.
     *
     * @param  null $locale
     * @return null|string
     */
    public function getInstructions($locale = null)
    {
        return $this->translateOrDefault($locale)->instructions;
    }

    /**
     * Get the placeholder.
     *
     * @param  null $locale
     * @return null|string
     */
    public function getPlaceholder($locale = null)
    {
        return $this->translateOrDefault($locale)->placeholder;
    }

    /**
     * Get the related stream.
     *
     * @return mixed
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
        return ($this->unique);
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
        $this->attributes['rules'] = serialize($rules);
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
        return unserialize($rules);
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
     * Return the stream relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stream()
    {
        return $this->belongsTo('Anomaly\Streams\Platform\Stream\StreamModel', 'stream_id');
    }

    /**
     * Return the field relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function field()
    {
        return $this->belongsTo('Anomaly\Streams\Platform\Field\FieldModel');
    }
}
