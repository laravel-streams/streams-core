<?php namespace Streams\Platform\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Laracasts\Commander\Events\EventGenerator;

use Streams\Platform\Traits\CacheableTrait;
use Streams\Platform\Traits\ObservableTrait;
use Streams\Platform\Traits\RevisionableTrait;
use Streams\Platform\Traits\TranslatableTrait;
use Streams\Platform\Contract\PresenterInterface;
use Streams\Platform\Contract\ArrayableInterface;
use Streams\Platform\Collection\EloquentCollection;
use Streams\Platform\Model\Observer\EloquentObserver;
use Streams\Platform\Model\Presenter\EloquentPresenter;

class EloquentModel extends Model implements ArrayableInterface, PresenterInterface
{
    use TranslatableTrait {
        TranslatableTrait::save as translatableSave;
    }

    use RevisionableTrait;
    use CacheableTrait;
    use ObservableTrait;

    use EventGenerator;

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

    /**
     * Return an identifiable name.
     *
     * @return string
     */
    public function identifiableName()
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

    /**
     * Return a new resource instance.
     *
     * @param $resource
     * @return EloquentPresenter
     */
    public function newPresenter($resource)
    {
        return new EloquentPresenter($resource);
    }
}
