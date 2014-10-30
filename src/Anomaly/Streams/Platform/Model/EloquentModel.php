<?php namespace Anomaly\Streams\Platform\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Anomaly\Streams\Platform\Traits\CacheableTrait;
use Anomaly\Streams\Platform\Traits\EventableTrait;
use Anomaly\Streams\Platform\Traits\CommandableTrait;
use Anomaly\Streams\Platform\Traits\RevisionableTrait;
use Anomaly\Streams\Platform\Traits\TranslatableTrait;
use Anomaly\Streams\Platform\Contract\ArrayableInterface;
use Anomaly\Streams\Platform\Contract\PresentableInterface;
use Anomaly\Streams\Platform\Collection\EloquentCollection;

class EloquentModel extends Model implements ArrayableInterface, PresentableInterface
{
    use TranslatableTrait {
        TranslatableTrait::save as translatableSave;
    }

    use EventableTrait;
    use CacheableTrait;
    use CommandableTrait;
    use RevisionableTrait;

    /**
     * Translatable flag.
     *
     * @var bool
     */
    protected $translatable = false;

    /**
     * Translatable attributes.
     *
     * @var array
     */
    protected $translatedAttributes = [];

    /**
     * Revisionable flag.
     *
     * @var bool
     */
    protected $revisionable = false;

    /**
     * Validate the model by default.
     *
     * @var boolean
     */
    protected $validate = true;

    /**
     * The number of minutes to cache query results.
     *
     * @var boolean/int
     */
    protected $cacheMinutes = false;

    /**
     * The attributes that are not mass assignable
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        self::observe(new EloquentObserver());
    }

    /**
     * Save the model.
     *
     * @param array    $rules
     * @param array    $customMessages
     * @param array    $options
     * @param \Closure $beforeSave
     * @param \Closure $afterSave
     * @return bool
     */
    public function save(
        array $rules = array(),
        array $customMessages = array(),
        array $options = array(),
        \Closure $beforeSave = null,
        \Closure $afterSave = null
    ) {
        if ($this->translatable) {
            return $this->translatableSave($options);
        } else {
            return parent::save($rules, $customMessages, $options, $beforeSave, $afterSave);
        }
    }

    public function decorate()
    {
        return new EloquentPresenter($this);
    }

    /**
     * Return an identifiable name.
     *
     * @return string
     */
    public function getIdentifiableName()
    {
        return $this->getKey();
    }

    /**
     * Return the is revisionable attribute.
     *
     * @return bool
     */
    public function getIsRevisionableAttribute()
    {
        return isset($this->attributes['is_revisionable']) ? $this->attributes['is_revisionable'] : false;
    }

    /**
     * Return a new collection class with our models.
     *
     * @param array $models
     * @return Collection
     */
    public function newCollection(array $models = array())
    {
        return new EloquentCollection($models);
    }

    /**
     * Get the validate property.
     *
     * @return bool
     */
    public function getValidate()
    {
        return $this->validate;
    }

    /**
     * Set the validate property.
     *
     * @param $validate
     * @return $this
     */
    public function setValidate($validate)
    {
        $this->validate = ($validate);

        return $this;
    }

    public function isTranslatable()
    {
        return ($this->translatable);
    }
}
