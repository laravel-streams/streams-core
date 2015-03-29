<?php namespace Anomaly\Streams\Platform\Field;

use Anomaly\Streams\Platform\Addon\FieldType\Command\BuildFieldType;
use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
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
        'name'
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
     * Boot the model.
     */
    protected static function boot()
    {
        self::observe(app('Anomaly\Streams\Platform\Field\FieldObserver'));

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
     * Get the slug.
     *
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
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
     * @return FieldType
     */
    public function getType()
    {
        $type   = $this->type;
        $field  = $this->slug;
        $label  = $this->name;
        $config = $this->config;

        return $this->dispatch(new BuildFieldType(compact('type', 'field', 'label', 'config', 'locale')));
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
     * Get the validation rules.
     *
     * @return mixed
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * Get the related assignments.
     *
     * @return mixed
     */
    public function getAssignments()
    {
        return $this->assignments;
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
        $this->attributes['config'] = (array)serialize($config);
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
     * Set rules attribute.
     *
     * @param array $rules
     */
    public function setRulesAttribute($rules)
    {
        $this->attributes['rules'] = serialize((array)$rules);
    }

    /**
     * Return the decoded rules attribute.
     *
     * @param  $rules
     * @return mixed
     */
    public function getRulesAttribute($rules)
    {
        return (array)unserialize($rules);
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
