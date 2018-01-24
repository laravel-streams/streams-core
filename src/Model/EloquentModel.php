<?php namespace Anomaly\Streams\Platform\Model;

use Anomaly\Streams\Platform\Collection\CacheCollection;
use Anomaly\Streams\Platform\Model\Traits\Translatable;
use Anomaly\Streams\Platform\Traits\Hookable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Robbo\Presenter\PresentableInterface;

/**
 * Class EloquentModel
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class EloquentModel extends Model implements Arrayable, PresentableInterface
{

    use Hookable;
    use Translatable;
    use DispatchesJobs;

    /**
     * Disable timestamps for this model.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Searchable attributes.
     *
     * @var array
     */
    protected $searchableAttributes = [];

    /**
     * The number of minutes to cache query results.
     *
     * @var null|false|int
     */
    protected $ttl = false;

    /**
     * The attributes that are
     * not mass assignable. Let upper
     * models handle this themselves.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The title key.
     *
     * @var string
     */
    protected $titleKey = 'id';

    /**
     * Observable model events.
     *
     * @var array
     */
    protected $observables = [
        'updatingMultiple',
        'updatedMultiple',
        'deletingMultiple',
        'deletedMultiple',
    ];

    /**
     * The cascading delete-able relations.
     *
     * @var array
     */
    protected $cascades = [];

    /**
     * Runtime cache.
     *
     * @var array
     */
    protected $cache = [];

    /**
     * Get the ID.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Return the object's ETag fingerprint.
     *
     * @return string
     */
    public function etag()
    {
        return md5(get_class($this) . json_encode($this->toArray()));
    }

    /**
     * Cache a value in the
     * model's cache collection.
     *
     * @param $key
     * @param $ttl
     * @param $value
     * @return mixed
     */
    public function cache($key, $ttl, $value)
    {
        (new CacheCollection())
            ->make([$key])
            ->setKey($this->getCacheCollectionKey())
            ->index();

        return app('cache')->remember(
            $key,
            $ttl ?: $this->getTtl(),
            $value
        );
    }

    /**
     * Fire a model event.
     *
     * @param $event
     * @return mixed
     */
    public function fireEvent($event)
    {
        return $this->fireModelEvent($event);
    }

    /**
     * Return the entry presenter.
     *
     * This is against standards but required
     * by the presentable interface.
     *
     * @return EloquentPresenter
     */
    public function getPresenter()
    {
        $presenter = substr(get_class($this), 0, -5) . 'Presenter';

        if (class_exists($presenter)) {
            return app()->make($presenter, ['object' => $this]);
        }

        return new EloquentPresenter($this);
    }

    /**
     * Return a new collection class with our models.
     *
     * @param  array $items
     * @return Collection
     */
    public function newCollection(array $items = [])
    {
        $collection = substr(get_class($this), 0, -5) . 'Collection';

        if (class_exists($collection)) {
            return new $collection($items);
        }

        return new EloquentCollection($items);
    }

    /**
     * Set the ttl.
     *
     * @param  $ttl
     * @return $this
     */
    public function setTtl($ttl)
    {
        $this->ttl = $ttl;

        return $this;
    }

    /**
     * Get the ttl.
     *
     * @return int|mixed
     */
    public function getTtl()
    {
        return $this->ttl;
    }

    /**
     * Get cache collection key.
     *
     * @return string
     */
    public function getCacheCollectionKey()
    {
        return get_called_class();
    }

    /**
     * Get the model title.
     *
     * @return mixed
     */
    public function getTitle()
    {
        return $this->{$this->getTitleName()};
    }

    /**
     * Get the title key.
     *
     * @return string
     */
    public function getTitleName()
    {
        return $this->titleName ?: 'id';
    }

    /**
     * Return if a row is deletable or not.
     *
     * @return bool
     */
    public function isDeletable()
    {
        return true;
    }

    /**
     * Return if the model is restorable or not.
     *
     * @return bool
     */
    public function isRestorable()
    {
        return true;
    }

    /**
     * Return whether the model is being
     * force deleted or not.
     *
     * @return bool
     */
    public function isForceDeleting()
    {
        return isset($this->forceDeleting) && $this->forceDeleting === true;
    }

    /**
     * Flush the model's cache.
     *
     * @return $this
     */
    public function flushCache()
    {
        (new CacheCollection())->setKey($this->getCacheCollectionKey())->flush();

        $this->flushRuntimeCache();

        return $this;
    }

    /**
     * Flush the runtime cache.
     *
     * @return $this
     */
    public function flushRuntimeCache()
    {
        EloquentQueryBuilder::dropRuntimeCache($this->getCacheCollectionKey());

        $this->cache = [];

        return $this;
    }

    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  \Illuminate\Database\Query\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function newEloquentBuilder($query)
    {
        $builder = substr(get_class($this), 0, -5) . 'QueryBuilder';

        if (class_exists($builder)) {
            return new $builder($query);
        }

        return new EloquentQueryBuilder($query);
    }

    /**
     * Return searchable attributes.
     *
     * @return array
     */
    public function getSearchableAttributes()
    {
        return $this->searchableAttributes;
    }

    /**
     * Get an attribute.
     *
     * @param string $key
     * @return mixed|null
     */
    public function getAttribute($key)
    {
        if ($this->isTranslatedAttribute($key)) {

            if (($translation = $this->getTranslation()) === null) {
                return null;
            }

            $translation->setRelation('parent', $this);

            return $translation->$key;
        }

        return parent::getAttribute($key);
    }

    /**
     * Set an attribute.
     *
     * @param  string $key
     * @param  mixed $value
     * @return $this
     */
    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->translatedAttributes)) {
            $this->getTranslationOrNew(config('app.locale'))->$key = $value;
        } else {
            parent::setAttribute($key, $value);
        }

        return $this;
    }

    /**
     * Save the model.
     *
     * We have some customization here to
     * accommodate translations. First sa
     * then save translations is translatable.
     *
     * @param  array $options
     * @return bool
     */
    public function save(array $options = [])
    {
        if (!$this->getTranslationModelName()) {
            return $this->saveModel($options);
        }

        if ($this->exists) {
            if (count($this->getDirty()) > 0) {

                // If $this->exists and dirty, $this->saveModel() has to return true. If not,
                // an error has occurred. Therefore we shouldn't save the translations.
                if ($this->saveModel($options)) {
                    return $this->saveTranslations();
                }

                return false;
            } else {

                // If $this->exists and not dirty, $this->saveModel() skips saving and returns
                // false. So we have to save the translations
                return $this->saveTranslations();
            }
        } elseif ($this->saveModel($options)) {

            // We save the translations only if the instance is saved in the database.
            return $this->saveTranslations();
        }

        return false;
    }

    /**
     * Save the model to the database.
     *
     * This is a direct port from Eloquent
     * with the only exception being that if
     * the model is translatable it will NOT
     * fire the saved event. The saveTranslations
     * method will do that instead.
     *
     * @param  array $options
     * @return bool
     */
    public function saveModel(array $options = [])
    {
        $query = $this->newQueryWithoutScopes();

        // If the "saving" event returns false we'll bail out of the save and return
        // false, indicating that the save failed. This provides a chance for any
        // listeners to cancel save operations if validations fail or whatever.
        if ($this->fireModelEvent('saving') === false) {
            return false;
        }

        // If the model already exists in the database we can just update our record
        // that is already in this database using the current IDs in this "where"
        // clause to only update this model. Otherwise, we'll just insert them.
        if ($this->exists) {
            $saved = $this->performUpdate($query, $options);
        }

        // If the model is brand new, we'll insert it into our database and set the
        // ID attribute on the model to the value of the newly inserted row's ID
        // which is typically an auto-increment value managed by the database.
        else {
            $saved = $this->performInsert($query, $options);
        }

        if ($saved && !$this->isTranslatable()) {
            $this->finishSave($options);
        }

        return $saved;
    }

    /**
     * Fill the model attributes.
     *
     * @param array $attributes
     * @return $this
     */
    public function fill(array $attributes)
    {
        foreach ($attributes as $key => $values) {
            if (is_array($values) && $this->isKeyALocale($key)) {
                foreach ($values as $translationAttribute => $translationValue) {
                    if ($this->alwaysFillable() || $this->isFillable($translationAttribute)) {
                        $this->getTranslationOrNew($key)->$translationAttribute = $translationValue;
                    }
                }
                unset($attributes[$key]);
            }
        }

        return parent::fill($attributes);
    }

    /**
     * Return if the attribute
     * is searchable or not.
     *
     * @param $key
     * @return bool
     */
    public function isSearchableAttribute($key)
    {
        return in_array($key, $this->searchableAttributes);
    }

    /**
     * Return unguarded attributes.
     *
     * @return array
     */
    public function getUnguardedAttributes()
    {
        foreach ($attributes = $this->getAttributes() as $attribute => $value) {
            $attributes[$attribute] = $value;
        }

        return array_diff_key($attributes, array_flip($this->getGuarded()));
    }

    /**
     * Get the default locale.
     *
     * @return string
     */
    protected function getDefaultLocale()
    {
        if (isset($this->cache['default_locale'])) {
            return $this->cache['default_locale'];
        }

        return $this->cache['default_locale'] = config('streams::locales.default');
    }

    /**
     * Get the fallback locale.
     *
     * @return string
     */
    protected function getFallbackLocale()
    {
        if (isset($this->cache['fallback_locale'])) {
            return $this->cache['fallback_locale'];
        }

        return $this->cache['fallback_locale'] = config('app.fallback_locale');
    }

    /**
     * This is to keep consistency with the
     * entry interface above us.
     *
     * @return string
     */
    public function getTableName()
    {
        return $this->getTable();
    }

    /**
     * Return the model as an array.
     *
     * @return array
     */
    public function toArray()
    {
        $attributes = $this->attributesToArray();

        foreach ($this->translatedAttributes as $field) {
            if ($translation = $this->getTranslation()) {
                $attributes[$field] = $translation->$field;
            }
        }

        return $attributes;
    }

    /**
     * Return the routable array information.
     *
     * @return array
     */
    public function toRoutableArray()
    {
        return $this->toArray();
    }

    /**
     * We protect things a little
     * differently so open er up.
     *
     * @return bool
     */
    private function alwaysFillable()
    {
        return false;
    }

    /**
     * Determine if the given attribute exists.
     * Make sure to skip where there could be an
     * issue with relational "looking" properties.
     *
     * @param  mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return !method_exists($this, $offset) && !is_null($this->$offset);
    }

    /**
     * Get the criteria class.
     *
     * @return string
     */
    public function getCriteriaName()
    {
        $criteria = substr(get_class($this), 0, -5) . 'Criteria';

        return class_exists($criteria) ? $criteria : EloquentCriteria::class;
    }

    /**
     * Get the cascading actions.
     *
     * @return array
     */
    public function getCascades()
    {
        return $this->cascades;
    }

    /**
     * Check hooks for the missing key.
     *
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        if ($this->hasHook($hook = 'get_' . $key)) {
            return $this->call($hook, []);
        }

        return parent::__get($key);
    }

    /**
     * Check hooks for the missing method.
     *
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if ($this->hasHook($hook = snake_case($method))) {
            return $this->call($hook, $parameters);
        }

        return parent::__call($method, $parameters);
    }

    /**
     * Check if an attribute exists.
     *
     * @param  string $key
     * @return bool
     */
    public function __isset($key)
    {
        return (in_array($key, $this->translatedAttributes) || parent::__isset($key));
    }

    /**
     * Return the string form of the model.
     *
     * @return string
     */
    public function __toString()
    {
        return json_encode($this->toArray());
    }

    /**
     * Remove volatile cache from
     * objects before serialization.
     *
     * @return array
     */
    public function __sleep()
    {
        return array_diff(array_keys(get_object_vars($this)), ['cache']);
    }
}
