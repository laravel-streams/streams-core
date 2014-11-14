<?php namespace Anomaly\Streams\Platform\Model;

use Anomaly\Streams\Platform\Collection\EloquentCollection;
use Anomaly\Streams\Platform\Contract\ArrayableInterface;
use Anomaly\Streams\Platform\Contract\PresentableInterface;
use Anomaly\Streams\Platform\Support\Transformer;
use Anomaly\Streams\Platform\Traits\CacheableTrait;
use Anomaly\Streams\Platform\Traits\CommandableTrait;
use Anomaly\Streams\Platform\Traits\EventableTrait;
use Anomaly\Streams\Platform\Traits\TranslatableTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class EloquentModel extends Model implements ArrayableInterface, PresentableInterface
{

    use TranslatableTrait {
        TranslatableTrait::save as translatableSave;
    }

    use EventableTrait;
    use CacheableTrait;
    use CommandableTrait;

    /**
     * Translatable flag.
     *
     * @var bool
     */
    protected $translatable = false;

    /**
     * Default translatable models to allow fallback.
     *
     * @var bool
     */
    protected $useTranslationFallback = true;

    /**
     * Translatable attributes.
     *
     * @var array
     */
    protected $translatedAttributes = [];

    /**
     * Validate the model by default.
     *
     * @var boolean
     */
    protected $validate = true;

    /**
     * The number of minutes to cache query results.
     *
     * @var null
     */
    protected $cacheMinutes = false;

    /**
     * The attributes that are not mass assignable
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Observable model events.
     *
     * These are merged with the parent
     * observable events.
     *
     * @var array
     */
    protected $observables = [];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // TODO: This looses persistence for some reason if not set here.
        //self::$dispatcher = app('Illuminate\Contracts\Events\Dispatcher');

        // Observing is a must.
        $observer = 'Anomaly\Streams\Platform\Model\EloquentModelObserver';

        // If this class has it's own use it.
        if ($override = (new Transformer())->toObserver(__CLASS__)) {

            $observer = $override;
        }

        // If the called class has it's own use it.
        if ($override = (new Transformer())->toObserver(get_called_class())) {

            $observer = $override;
        }

        self::observe(new $observer);
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

    public function getObservableEvents()
    {
        return array_unique(array_merge(parent::getObservableEvents(), $this->observables));
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

    public function setCacheMinutes($cacheMinutes)
    {
        $this->cacheMinutes = $cacheMinutes;

        return $this;
    }

    public function getCacheMinutes()
    {
        return $this->cacheMinutes;
    }

    public function getCacheCollectionKey($suffix = null)
    {
        return $this->getCacheCollectionPrefix() . $suffix;
    }

    public function getCacheCollectionPrefix()
    {
        return get_called_class();
    }

    public function flushCacheCollection()
    {
        app('streams.cache.collection')->setKey($this->getCacheCollectionKey())->flush();

        return $this;
    }

    /**
     * Get a new query builder for the model's table.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function newQuery()
    {
        $builder = new EloquentQueryBuilder($this->newBaseQueryBuilder());

        // Once we have the query builders, we will set the model instances so the
        // builder can easily access any information it may need from the model
        // while it is constructing and executing various queries against it.
        $builder->setModel($this)->with($this->with);

        return $this->applyGlobalScopes($builder);
    }
}
