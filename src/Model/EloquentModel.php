<?php namespace Anomaly\Streams\Platform\Model;

use Anomaly\Streams\Platform\Collection\CacheCollection;
use Anomaly\Streams\Platform\Traits\Hookable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class EloquentModel
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Model
 */
class EloquentModel extends Model implements Arrayable
{

    use DispatchesJobs;
    use Hookable;

    /**
     * Disable timestamps for this model.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Translatable attributes.
     *
     * @var array
     */
    protected $translatedAttributes = [];

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
        'deletedMultiple'
    ];

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
     * Alias for $this->setTtl($ttl)
     *
     * @param $ttl
     * @return EloquentModel
     */
    public function cache($ttl)
    {
        return $this->setTtl($ttl);
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
        $collection = substr(get_class($this), 0, -5) . 'Collection';

        if (class_exists($collection)) {
            return new $collection($items);
        }

        return new EloquentCollection($items);
    }

    /**
     * Return the translatable flag.
     *
     * @return bool
     */
    public function isTranslatable()
    {
        return isset($this->translationModel);
    }

    /**
     * Set the translatable flag.
     *
     * @param $translatable
     * @return $this
     */
    public function setTranslatable($translatable)
    {
        $this->translatable = $translatable;

        return $this;
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
        return isset($this->forceDeleting) && $this->forceDeleting == true;
    }

    /**
     * Flush the model's cache.
     *
     * @return $this
     */
    public function flushCache()
    {
        (new CacheCollection())->setKey($this->getCacheCollectionKey())->flush();

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
        return $this->getTranslation($locale, true) ?: $this;
    }

    /*
     * Alias for getTranslationOrNew()
     */
    public function translateOrNew($locale)
    {
        return $this->getTranslationOrNew($locale);
    }

    /**
     * Get related translations.
     *
     * @return EloquentCollection
     */
    public function getTranslations()
    {
        foreach ($translations = $this->translations()->get() as $translation) {
            $translation->setRelation('parent', $this);
        }

        return $translations;
    }

    /**
     * @param null      $locale
     * @param bool|null $withFallback
     * @return Model|null
     */
    public function getTranslation($locale = null, $withFallback = false)
    {
        $locale = $locale ?: $this->getFallbackLocale();

        if ($translation = $this->getTranslationByLocaleKey($locale)) {
            return $translation;
        } elseif ($withFallback
            && $this->getFallbackLocale()
            && $this->getTranslationByLocaleKey($this->getFallbackLocale())
        ) {
            return $this->getTranslationByLocaleKey($this->getFallbackLocale());
        }

        return null;
    }

    public function hasTranslation($locale = null)
    {
        $locale = $locale ?: $this->getFallbackLocale();

        foreach ($this->translations as $translation) {

            $translation->setRelation('parent', $this);

            if ($translation->getAttribute($this->getLocaleKey()) == $locale) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get the translation model.
     *
     * @return EloquentModel
     */
    public function getTranslationModel()
    {
        return new $this->translationModel;
    }

    /**
     * Get the translation model name.
     *
     * @return string
     */
    public function getTranslationModelName()
    {
        return $this->translationModel;
    }

    /**
     * Get the translation table name.
     *
     * @return string
     */
    public function getTranslationTableName()
    {
        $model = $this->getTranslationModel();

        return $model->getTableName();
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
        if ($this->isTranslatedAttribute($key)) {
            if ($this->getTranslation() === null) {
                return null;
            }

            $translation = $this->getTranslation();

            $translation->setRelation('parent', $this);

            return $translation->$key;
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

    /**
     * Save the model.
     *
     * We have some customization here to
     * accommodate translations. First sa
     * then save translations is translatable.
     *
     * @param array $options
     * @return bool
     */
    public function save(array $options = array())
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
    public function saveModel(array $options = array())
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
     * Save translations to the database.
     *
     * @return bool
     */
    protected function saveTranslations()
    {
        $saved = true;

        foreach ($this->translations as $translation) {

            $translation->setRelation('parent', $this);

            /* @var EloquentModel $translation */
            if ($saved && $this->isTranslationDirty($translation)) {

                $translation->setAttribute($this->getRelationKey(), $this->getKey());

                $saved = $translation->save();
            }
        }

        $this->finishSave([]);

        return $saved;
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

    private function getTranslationByLocaleKey($key)
    {
        foreach ($this->translations as $translation) {

            $translation->setRelation('parent', $this);

            if ($translation->getAttribute($this->getLocaleKey()) == $key) {
                return $translation;
            }
        }

        return null;
    }

    public function isTranslatedAttribute($key)
    {
        return in_array($key, $this->translatedAttributes);
    }

    protected function isTranslationAttribute($key)
    {
        return in_array($key, $this->translatedAttributes);
    }

    protected function isKeyALocale($key)
    {
        return config('streams::locales.supported.' . $key) !== null;
    }

    protected function isTranslationDirty(Model $translation)
    {
        $dirtyAttributes = $translation->getDirty();
        unset($dirtyAttributes[$this->getLocaleKey()]);

        return count($dirtyAttributes) > 0;
    }

    public function getNewTranslation($locale)
    {
        $modelName = $this->getTranslationModelName();

        /* @var EloquentModel $translation */
        $translation = new $modelName;

        $translation->setRelation('parent', $this);

        $translation->setAttribute($this->getLocaleKey(), $locale);
        $translation->setAttribute($this->getRelationKey(), $this->getKey());

        $this->translations->add($translation);

        return $translation;
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

    /**
     * Return unguarded attributes.
     *
     * @return array
     */
    public function getUnguardedAttributes()
    {
        foreach ($attributes = $this->getAttributes() as $attribute => $value) {
            $attributes[$attribute] = $this->{$attribute};
        }

        return array_diff_key($attributes, array_flip($this->getGuarded()));
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
     * Return if the entry is trashed or not.
     *
     * @return bool
     */
    public function trashed()
    {
        return parent::trashed();
    }

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
        return !method_exists($this, $offset) && isset($this->$offset);
    }

    public function __get($key)
    {
        if ($this->hasHook($key)) {
            return $this->call($key, []);
        }

        return parent::__get($key); // TODO: Change the autogenerated stub
    }

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
     * @param string $key
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
    function __toString()
    {
        return json_encode($this->toArray());
    }
}
