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
     * This is a translatable model.
     *
     * @var bool
     */
    protected $translatable = true;

    /**
     * The foreign key for translations.
     *
     * @var string
     */
    protected $translationForeignKey = 'assignment_id';

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
    public function getFieldType()
    {
        // Get the type object from our related field.
        $field = $this->getField();

        $type = $field->getType();

        // These are always on or off so set em.
        $type->setRequired($this->isRequired());
        $type->setTranslatable($this->isTranslatable());

        $locale = 'en';

        /**
         * This is already set as the field name.
         * If the label is available (translated)
         * set it as type's label.
         */
        if ($label = $this->getLabel($locale)) {
            $type->setLabel($label);
        }

        /**
         * This defaults to null but it's translation
         * string is automated. If the translation is
         * available set the  instructions on the type.
         */
        if ($instructions = $this->getInstructions($locale)) {
            $type->setInstructions($instructions);
        }

        return $type;
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
        $locale = $locale ?: config('app.locale');

        $assignment = $this->translate($locale) ?: $this;

        $label = $assignment->label;

        if (trans($label) !== $label) {
            return trans($label, [], null, $locale);
        }

        return null;
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
        $locale = $locale ?: config('app.locale');

        $assignment = $this->translate($locale) ?: $this;

        $instructions = $assignment->instructions;

        if (trans($instructions) !== $instructions) {
            return trans($instructions, [], null, $locale);
        }

        return null;
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
     * @return mixed
     */
    public function isRequired()
    {
        return ($this->required);
    }

    /**
     * Get  the translatable flag.
     *
     * @return bool|mixed
     */
    public function isTranslatable()
    {
        return ($this->translatable && $this->stream->translatable);
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
