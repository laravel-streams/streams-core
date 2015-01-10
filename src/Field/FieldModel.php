<?php namespace Anomaly\Streams\Platform\Field;

use Anomaly\Streams\Platform\Addon\FieldType\Contract\RelationFieldTypeInterface;
use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Dimsav\Translatable\Translatable;

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

    use Translatable;

    /**
     * Do not use timestamps.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * This model is translatable.
     *
     * @var bool
     */
    protected $translatable = true;

    /**
     * The foreign key for translations.
     *
     * @var string
     */
    protected $translationForeignKey = 'field_id';

    /**
     * The database table name.
     *
     * @var string
     */
    protected $table = 'streams_fields';

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
     * @return mixed
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
     * Get the field type.
     *
     * @return mixed
     */
    public function getType(EntryInterface $entry = null, $locale = null)
    {
        $type   = $this->type;
        $field  = $this->slug;
        $label  = $this->name;
        $config = $this->config;

        $locale = $locale ?: config('app.locale');

        $data = compact('type', 'field', 'label', 'config', 'locale');

        $command = 'Anomaly\Streams\Platform\Addon\FieldType\Command\BuildFieldTypeCommand';

        $type = $this->dispatchFromArray($command, $data);

        if ($entry && $type instanceof FieldType) {
            if (!$type instanceof RelationFieldTypeInterface) {
                $type->setValue($entry->getFieldValue($field, $locale, false));
            }
        }

        return $type;
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
        $this->attributes['config'] = serialize($config);
    }

    /**
     * Return the decoded config attribute.
     *
     * @param  $config
     * @return mixed
     */
    public function getConfigAttribute($config)
    {
        return unserialize($config);
    }

    /**
     * Set rules attribute.
     *
     * @param array $rules
     */
    public function setRulesAttribute($rules)
    {
        $this->attributes['rules'] = serialize($rules);
    }

    /**
     * Return the decoded rules attribute.
     *
     * @param  $rules
     * @return mixed
     */
    public function getRulesAttribute($rules)
    {
        return unserialize($rules);
    }

    /**
     * Return the assignments relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function assignments()
    {
        return $this->hasMany(config('streams::config.assignments.model'), 'field_id')->orderBy('sort_order');
    }
}
