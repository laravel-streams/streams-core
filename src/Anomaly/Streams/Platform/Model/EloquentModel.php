<?php namespace Anomaly\Streams\Platform\Model;

use Anomaly\Streams\Platform\Contract\ArrayableInterface;
use Anomaly\Streams\Platform\Contract\PresentableInterface;
use Anomaly\Streams\Platform\Traits\CacheableTrait;
use Anomaly\Streams\Platform\Traits\TransformableTrait;
use Anomaly\Streams\Platform\Traits\TranslatableTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EloquentModel
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Model
 */
class EloquentModel extends Model implements ArrayableInterface, PresentableInterface
{

    use TranslatableTrait {
        TranslatableTrait::save as translatableSave;
    }

    use CacheableTrait;
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
     * The title key.
     *
     * @var string
     */
    protected $titleKey = 'id';

    /**
     * Boot the model.
     *
     * @return void
     */
    protected static function boot()
    {
        self::observe(new EloquentModelObserver());
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
     * Return the presenter counterpart object.
     *
     * @return mixed
     */
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

    /**
     * Return the translatable flag.
     *
     * @return bool
     */
    public function isTranslatable()
    {
        return ($this->translatable);
    }

    /**
     * Flush the cache collection.
     *
     * @return $this
     */
    public function flushCacheCollection()
    {
        app('streams.cache.collection')->setKey($this->getCacheCollectionKey())->flush();

        return $this;
    }

    /**
     * Set the cache minutes.
     *
     * @param $cacheMinutes
     * @return $this
     */
    public function setCacheMinutes($cacheMinutes)
    {
        $this->cacheMinutes = $cacheMinutes;

        return $this;
    }

    /**
     * Get the cache minutes.
     *
     * @return null
     */
    public function getCacheMinutes()
    {
        return $this->cacheMinutes;
    }

    /**
     * Get cache collection key.
     *
     * @param null $suffix
     * @return string
     */
    public function getCacheCollectionKey($suffix = null)
    {
        return get_called_class() . $suffix;
    }

    /**
     * Get the model title.
     *
     * @return mixed
     */
    public function getTitle()
    {
        return $this->{$this->getTitleKey()};
    }

    /**
     * Get the title key.
     *
     * @return string
     */
    public function getTitleKey()
    {
        return $this->titleKey ? : 'id';
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
