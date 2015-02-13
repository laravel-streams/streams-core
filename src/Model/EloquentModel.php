<?php namespace Anomaly\Streams\Platform\Model;

use Anomaly\Streams\Platform\Collection\CacheCollection;
use Anomaly\Streams\Platform\Ui\Table\Table;
use Illuminate\Database\Eloquent\Builder;
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
class EloquentModel extends Model
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
     * Not translatable by default.
     *
     * @var bool
     */
    protected $translatable = false;

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
     * Observable model events.
     *
     * @var array
     */
    protected $observables = [
        'updatingMultiple',
        'updatedMultiple',
        'deletingMultiple',
        'deletedMultiple'
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        self::observe(app('Anomaly\Streams\Platform\Model\EloquentObserver'));

        parent::boot();
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
        (new CacheCollection())->setKey($this->getCacheCollectionKey())->flush();
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

    /*
     * Alias for getTranslation()
     */
    public function translate($locale = null, $withFallback = false)
    {
        return $this->getTranslation($locale, $withFallback);
    }

    /*
     * Alias for getTranslation()
     */
    public function translateOrDefault($locale)
    {
        return $this->getTranslation($locale, false) ?: $this;
    }

    /*
     * Alias for getTranslationOrNew()
     */
    public function translateOrNew($locale)
    {
        return $this->getTranslationOrNew($locale);
    }

    /**
     * @param null      $locale
     * @param bool|null $withFallback
     * @return Model|null
     */
    public function getTranslation($locale = null, $withFallback = null)
    {
        $locale = $locale ?: config('app.locale');

        if ($withFallback === null) {
            $withFallback = isset($this->useTranslationFallback) ? $this->useTranslationFallback : false;
        }

        if ($this->getTranslationByLocaleKey($locale)) {
            $translation = $this->getTranslationByLocaleKey($locale);
        } elseif ($withFallback
            && config('translatable::fallback_locale')
            && $this->getTranslationByLocaleKey(config('translatable::fallback_locale'))
        ) {
            $translation = $this->getTranslationByLocaleKey(config('translatable::fallback_locale'));
        } else {
            $translation = null;
        }

        return $translation;
    }

    public function hasTranslation($locale = null)
    {
        $locale = $locale ?: config('app.locale');

        foreach ($this->translations as $translation) {
            if ($translation->getAttribute($this->getLocaleKey()) == $locale) {
                return true;
            }
        }

        return false;
    }

    public function getTranslationModelName()
    {
        return $this->translationModel ?: $this->getTranslationModelNameDefault();
    }

    public function getTranslationModelNameDefault()
    {
        return get_class($this) . 'Translation';
    }

    public function getRelationKey()
    {
        return $this->translationForeignKey ?: $this->getForeignKey();
    }

    public function getLocaleKey()
    {
        return $this->localeKey ?: 'locale';
    }

    public function translations()
    {
        return $this->hasMany($this->getTranslationModelName(), $this->getRelationKey());
    }

    public function getAttribute($key)
    {
        if ($this->isKeyReturningTranslationText($key)) {
            if ($this->getTranslation() === null) {
                return null;
            }

            return $this->getTranslation()->$key;
        }

        return parent::getAttribute($key);
    }

    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->translatedAttributes)) {
            $this->getTranslationOrNew(config('app.locale'))->$key = $value;
        } else {
            parent::setAttribute($key, $value);
        }
    }

    public function save(array $options = array())
    {
        if (!$this->isTranslatable()) {
            return parent::save($options);
        }

        if ($this->exists) {
            if (count($this->getDirty()) > 0) {
                // If $this->exists and dirty, parent::save() has to return true. If not,
                // an error has occurred. Therefore we shouldn't save the translations.
                if (parent::save($options)) {
                    return $this->saveTranslations();
                }

                return false;
            } else {
                // If $this->exists and not dirty, parent::save() skips saving and returns
                // false. So we have to save the translations
                return $this->saveTranslations();
            }
        } elseif (parent::save($options)) {
            // We save the translations only if the instance is saved in the database.
            return $this->saveTranslations();
        }

        return false;
    }

    protected function getTranslationOrNew($locale)
    {
        if (($translation = $this->getTranslation($locale, false)) === null) {
            $translation = $this->getNewTranslation($locale);
        }

        return $translation;
    }

    public function fill(array $attributes)
    {
        foreach ($attributes as $key => $values) {
            if ($this->isKeyALocale($key)) {
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

    private function getTranslationByLocaleKey($key)
    {
        foreach ($this->translations as $translation) {
            if ($translation->getAttribute($this->getLocaleKey()) == $key) {
                return $translation;
            }
        }

        return null;
    }

    protected function isKeyReturningTranslationText($key)
    {
        return in_array($key, $this->translatedAttributes);
    }

    protected function isKeyALocale($key)
    {
        $locales = $this->getLocales();

        return in_array($key, $locales);
    }

    protected function getLocales()
    {
        return config('streams.available_locales');
    }

    protected function saveTranslations()
    {
        $saved = true;
        foreach ($this->translations as $translation) {
            if ($saved && $this->isTranslationDirty($translation)) {
                $translation->setAttribute($this->getRelationKey(), $this->getKey());
                $saved = $translation->save();
            }
        }

        return $saved;
    }

    protected function isTranslationDirty(Model $translation)
    {
        $dirtyAttributes = $translation->getDirty();
        unset($dirtyAttributes[$this->getLocaleKey()]);

        return count($dirtyAttributes) > 0;
    }

    public function getNewTranslation($locale)
    {
        $modelName   = $this->getTranslationModelName();
        $translation = new $modelName;
        $translation->setAttribute($this->getLocaleKey(), $locale);
        $translation->setAttribute($this->getRelationKey(), $this->getKey());
        $this->translations->add($translation);

        return $translation;
    }

    public function __isset($key)
    {
        return (in_array($key, $this->translatedAttributes) || parent::__isset($key));
    }

    public function scopeTranslatedIn(Builder $query, $locale)
    {
        return $query->whereHas(
            'translations',
            function (Builder $q) use ($locale) {
                $q->where($this->getLocaleKey(), '=', $locale);
            }
        );
    }

    public function scopeTranslated(Builder $query)
    {
        return $query->has('translations');
    }

    public function toArray()
    {
        $attributes = parent::toArray();

        foreach ($this->translatedAttributes AS $field) {
            if ($translations = $this->getTranslation()) {
                $attributes[$field] = $translations->$field;
            }
        }

        return $attributes;
    }

    private function alwaysFillable()
    {
        return false;
    }
}
