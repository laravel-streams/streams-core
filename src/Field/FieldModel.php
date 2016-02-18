<?php namespace Anomaly\Streams\Platform\Field;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeBuilder;
use Anomaly\Streams\Platform\Assignment\AssignmentCollection;
use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class FieldModel
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Field
 */
class FieldModel extends EloquentModel implements FieldInterface
{

    /**
     * Do not use timestamps.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Default attributes.
     *
     * @var array
     */
    protected $attributes = [
        'config' => 'a:0:{}'
    ];

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
    protected $translationForeignKey = 'field_id';

    /**
     * Translatable attributes.
     *
     * @var array
     */
    protected $translatedAttributes = [
        'name',
        'warning',
        'placeholder',
        'instructions'
    ];

    /**
     * The translation model.
     *
     * @var string
     */
    protected $translationModel = 'Anomaly\Streams\Platform\Field\FieldModelTranslation';

    /**
     * The database table name.
     *
     * @var string
     */
    protected $table = 'streams_fields';

    /**
     * The field type builder.
     *
     * @var FieldTypeBuilder
     */
    protected static $builder;

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        self::$builder = app(FieldTypeBuilder::class);

        parent::boot();
    }

    /**
     * Get the ID.
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->getKey();
    }

    /**
     * Get the name.
     *
     * @param null|string $locale
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the warning.
     *
     * @return string
     */
    public function getWarning()
    {
        return $this->warning;
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
     * Get the slug.
     *
     * @return mixed
     */
    public function getSlug()
    {
        return $this->getAttributeFromArray('slug');
    }

    /**
     * Get the stream.
     *
     * @return string
     */
    public function getStream()
    {
        return $this->stream;
    }

    /**
     * Get the namespace.
     *
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Get the field type.
     *
     * @param bool $fresh
     * @return FieldType|null
     * @throws \Exception
     */
    public function getType($fresh = false)
    {
        if ($fresh === false && isset($this->cache['type'])) {
            return $this->cache['type'];
        }

        $type   = $this->type;
        $field  = $this->slug;
        $label  = $this->name;
        $config = $this->config;

        if (!$type) {
            return $this->cache['type'] = null;
        }

        return $this->cache['type'] = self::$builder->build(compact('type', 'field', 'label', 'config'));
    }

    /**
     * Get the field type value.
     *
     * @return string
     */
    public function getTypeValue()
    {
        return $this->getAttributeFromArray('type');
    }

    /**
     * Get the configuration.
     *
     * @return mixed
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Get the related assignments.
     *
     * @return AssignmentCollection
     */
    public function getAssignments()
    {
        return $this->assignments;
    }

    /**
     * Return whether the field
     * has assignments or not.
     *
     * @return bool
     */
    public function hasAssignments()
    {
        $assignments = $this->getAssignments();

        return !$assignments->isEmpty();
    }

    /**
     * Return whether the field is
     * a relationship or not.
     *
     * @return bool
     */
    public function isRelationship()
    {
        return method_exists($this->getType(), 'getRelation');
    }

    /**
     * Get the locked flag.
     *
     * @return mixed
     */
    public function isLocked()
    {
        return ($this->locked);
    }

    /**
     * Set config attribute.
     *
     * @param array $config
     */
    public function setConfigAttribute($config)
    {
        $this->attributes['config'] = serialize((array)$config);
    }

    /**
     * Return the decoded config attribute.
     *
     * @param  $config
     * @return mixed
     */
    public function getConfigAttribute($config)
    {
        return (array)unserialize($config);
    }

    /**
     * Compile the fields's stream.
     *
     * @return FieldInterface
     */
    public function compileStreams()
    {
        /* @var AssignmentInterface $assignment */
        foreach ($this->getAssignments() as $assignment) {
            $assignment->compileStream();
        }

        return $this;
    }

    /**
     * Return the assignments relation.
     *
     * @return HasMany
     */
    public function assignments()
    {
        return $this->hasMany('Anomaly\Streams\Platform\Assignment\AssignmentModel', 'field_id')->orderBy('sort_order');
    }
}
