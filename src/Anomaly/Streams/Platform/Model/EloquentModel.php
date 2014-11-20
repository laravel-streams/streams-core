<?php namespace Anomaly\Streams\Platform\Model;

use Anomaly\Streams\Platform\Contract\ArrayableInterface;
use Anomaly\Streams\Platform\Contract\PresentableInterface;
use Anomaly\Streams\Platform\Support\Transformer;
use Anomaly\Streams\Platform\Traits\CacheableTrait;
use Anomaly\Streams\Platform\Traits\CommandableTrait;
use Anomaly\Streams\Platform\Traits\TransformableTrait;
use Anomaly\Streams\Platform\Traits\TranslatableTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class EloquentModel extends Model implements ArrayableInterface, PresentableInterface
{

    use TranslatableTrait {
        TranslatableTrait::save as translatableSave;
    }

    use CacheableTrait;
    use CommandableTrait;
    use TransformableTrait;

    /**
     * Disable timestamps for this model.
     *
     * @var bool
     */
    public $timestamps = false;

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
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // TODO: This looses persistence for some reason if not set here. Or.. it did. Don't give an iFuck
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

    public function flushCacheCollection()
    {
        app('streams.cache.collection')->setKey($this->getCacheCollectionKey())->flush();

        return $this;
    }

    public function newPresenter()
    {
        if (!$collection = $this->transform(__FUNCTION__)) {

            $collection = 'Anomaly\Streams\Platform\Model\EloquentModelPresenter';
        }

        return app()->make($collection, [$this]);
    }

    /**
     * Return a new collection class with our models.
     *
     * @param array $items
     * @return Collection
     */
    public function newCollection(array $items = array())
    {
        if (!$collection = $this->transform(__FUNCTION__)) {

            $collection = 'Anomaly\Streams\Platform\Collection\EloquentCollection';
        }

        return app()->make($collection, [$items]);
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
        return get_called_class() . $suffix;
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
