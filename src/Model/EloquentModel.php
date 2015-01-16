<?php namespace Anomaly\Streams\Platform\Model;

use Anomaly\Streams\Platform\Collection\CacheCollection;
use Anomaly\Streams\Platform\Ui\Table\Command\ModifyQuery;
use Anomaly\Streams\Platform\Ui\Table\Contract\TableModelInterface;
use Anomaly\Streams\Platform\Ui\Table\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\DispatchesCommands;

/**
 * Class EloquentModel
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Model
 */
class EloquentModel extends Model implements TableModelInterface
{

    use DispatchesCommands;

    /**
     * Disable timestamps for this model.
     *
     * @var bool
     */
    public $timestamps = false;

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
     */
    protected static function boot()
    {
        self::observe(app('Anomaly\Streams\Platform\Model\EloquentObserver'));

        parent::boot();
    }

    /**
     * Return a new collection class with our models.
     *
     * @param  array $items
     * @return Collection
     */
    public function newCollection(array $items = array())
    {
        return new EloquentCollection($items);
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
        return $this;
    }

    /**
     * Set the cache minutes.
     *
     * @param  $cacheMinutes
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
     * @return int|mixed
     */
    public function getCacheMinutes()
    {
        return $this->cacheMinutes;
    }

    /**
     * Get cache collection key.
     *
     * @param  null $suffix
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
        return $this->titleKey ?: 'id';
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

    /**
     * Get a cache collection of keys or set the keys to be indexed.
     *
     * @param  string $collectionKey
     * @param  array  $keys
     * @return object
     */
    public function cacheCollection($collectionKey, $keys = [])
    {
        if (is_string($keys)) {
            $keys = [$keys];
        }

        $cached = app('cache')->get($collectionKey);

        if (is_array($cached)) {
            $keys = array_merge($keys, $cached);
        }

        $collection = CacheCollection::make($keys);

        return $collection->setKey($collectionKey);
    }

    /**
     * Get a cache collection prefix.
     *
     * @return string
     */
    public function getCacheCollectionPrefix()
    {
        return get_called_class();
    }

    /**
     * Get table entries.
     *
     * @param Table $table
     * @return mixed
     */
    public function getTableEntries(Table $table)
    {
        // Get the options off the table.
        $options = $table->getOptions();

        // Start a new query.
        $query = $this->newQuery();

        /**
         * Prevent joins from overriding intended columns
         * by prefixing with the model's table name.
         */
        $query = $query->select($this->getTable() . '.*');

        /**
         * Eager load any relations to
         * save resources and queries.
         */
        $query = $query->with($options->get('eager', []));

        /**
         * Raise and dispatch an event here to allow
         * other things (including filters / views)
         * to modify the query before proceeding.
         */
        $this->dispatch(new ModifyQuery($table, $query));

        /**
         * Before we actually adjust the baseline query
         * set the total amount of entries possible back
         * on the table so it can be used later.
         */
        $total = $query->count();

        $options->put('total_results', $total);

        /**
         * Assure that our page exists. If the page does
         * not exist then start walking backwards until
         * we find a page that is has something to show us.
         */
        $limit  = $options->get('limit', 15);
        $page   = app('request')->get('page', 1);
        $offset = $limit * ($page - 1);

        if ($total < $offset && $page > 1) {
            $url = str_replace('page=' . $page, 'page=' . ($page - 1), app('request')->fullUrl());

            header('Location: ' . $url);
        }

        /**
         * Limit the results to the limit and offset
         * based on the page if any.
         */
        $offset = $limit * (app('request')->get('page', 1) - 1);

        $query = $query->take($limit)->offset($offset);

        /**
         * Order the query results.
         */
        foreach ($options->get('order_by', ['id' => 'asc']) as $column => $direction) {
            $query = $query->orderBy($column, $direction);
        }

        return $query->get();
    }

    /**
     * Update sorting based on the table input.
     *
     * @param Table $table
     * @return mixed
     */
    public function sortTableEntries(Table $table)
    {
        $options = $table->getOptions();

        $sortOrder = app('request')->get($options->get('prefix') . 'order');

        foreach ($sortOrder as $order => $id) {
            $this->where('id', $id)->update(['sort_order' => $order + 1]);
        }
    }
}
