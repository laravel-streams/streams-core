<?php namespace Anomaly\Streams\Platform\Model;

use Anomaly\Streams\Platform\Collection\CacheCollection;
use Anomaly\Streams\Platform\Contract\ArrayableInterface;
use Anomaly\Streams\Platform\Contract\PresentableInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Commander\CommanderTrait;
use Laracasts\Commander\Events\EventGenerator;

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

    use CommanderTrait;
    use EventGenerator;

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
            if ($this->exists) {

                if (parent::save($options)) {

                    return $this->saveTranslations();
                }

                return false;
            } elseif (parent::save($options)) {

                return $this->saveTranslations();
            }

            return false;
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
        return new EloquentPresenter($this);
    }

    /**
     * Return a new collection class with our models.
     *
     * @param array $items
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
        //app('streams.cache.collection')->setKey($this->getCacheCollectionKey())->flush();

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

        if ($cached = app('cache')->get($collectionKey) and is_array($cached)) {

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
     * Alias for getTranslation()
     */
    public function translate($locale = null, $defaultLocale = null, $createNew = true)
    {
        return $this->getTranslation($locale, $defaultLocale, $createNew);
    }

    /**
     * Alias for getTranslation()
     */
    public function translateOrDefault($locale)
    {
        return $this->getTranslation($locale, true, false);
    }

    /**
     * Get translation of model.
     *
     * @param null $locale
     * @param bool $withFallback
     * @return null
     */
    public function getTranslation($locale = null, $withFallback = false, $createNew = true)
    {
        if ($this->isTranslatable()) {

            $locale       = $locale ? : \App::getLocale();
            $withFallback = isset($this->useTranslationFallback) ? $this->useTranslationFallback : $withFallback;

            if ($this->getTranslationByLocaleKey($locale)) {

                $translation = $this->getTranslationByLocaleKey($locale);
            } elseif ($withFallback
                and \App::make('config')->has('app.fallback_locale')
                and $this->getTranslationByLocaleKey(\App::make('config')->get('app.fallback_locale'))
            ) {

                $translation = $this->getTranslationByLocaleKey(\App::make('config')->get('app.fallback_locale'));
            } elseif ($createNew) {

                $translation = $this->newTranslationInstance($locale);
                $this->translations->add($translation);
            } else {

                $translation = $this;
            }

            return $translation;
        }

        return $this;
    }

    /**
     * Check if the model has a translation.
     *
     * @param null $locale
     * @return bool
     */
    public function hasTranslation($locale = null)
    {
        $locale = $locale ? : \App::getLocale();

        foreach ($this->translations as $translation) {

            if ($translation->getAttribute($this->getLocaleKey()) == $locale) {

                return true;
            }
        }

        return false;
    }

    /**
     * Get the models translated name.
     *
     * @return string
     */
    public function getTranslationModelName()
    {
        return $this->translationModel ? : $this->getTranslationModelNameDefault();
    }

    /**
     * Return the default model translation name.
     *
     * @return string
     */
    public function getTranslationModelNameDefault()
    {
        $config = \App::make('config');

        return get_class($this) . $config->get('app.translatable_suffix', 'Translation');
    }

    /**
     * Get the relation key to native table.
     *
     * @return mixed
     */
    public function getRelationKey()
    {
        return $this->translationForeignKey ? : $this->getForeignKey();
    }

    /**
     * Get the local key.
     *
     * @return string
     */
    public function getLocaleKey()
    {
        return $this->localeKey ? : 'locale';
    }

    /**
     * Get an attribute value.
     *
     * @param $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        if ($this->isKeyReturningTranslationText($key)) {

            return $this->getTranslation()->$key;
        }

        return parent::getAttribute($key);
    }

    /**
     * @param $key
     * @param $locale
     * @return mixed
     */
    public function getTranslatedAttributeOrAttribute($key, $locale)
    {
        $default = parent::getAttribute($key);

        $translation = $this->translate($locale);

        $translated = $translation->getAttribute($key);

        return $translated ? : $default;
    }

    /**
     * Set an attribute value.
     *
     * @param $key
     * @param $value
     */
    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->translatedAttributes)) {

            $this->getTranslation()->$key = $value;
        } else {

            parent::setAttribute($key, $value);
        }
    }

    /**
     * Saturate the model data.
     *
     * @param array $attributes
     * @return mixed
     * @throws MassAssignmentException
     */
    public function fill(array $attributes)
    {
        $totallyGuarded = $this->totallyGuarded();

        foreach ($attributes as $key => $values) {

            if ($this->isKeyALocale($key)) {

                $translation = $this->getTranslation($key);

                foreach ($values as $translationAttribute => $translationValue) {

                    if ($this->isFillable($translationAttribute)) {

                        $translation->$translationAttribute = $translationValue;
                    } elseif ($totallyGuarded) {

                        throw new MassAssignmentException($key);
                    }
                }

                unset($attributes[$key]);
            }
        }

        return parent::fill($attributes);
    }

    /**
     * Get translation by locale key.
     *
     * @param $key
     * @return null
     */
    private function getTranslationByLocaleKey($key)
    {
        foreach ($this->translations as $translation) {

            if ($translation->getAttribute($this->getLocaleKey()) == $key) {

                return $translation;
            }
        }

        return null;
    }

    /**
     * Does the key return translated values?
     *
     * @param $key
     * @return bool
     */
    protected function isKeyReturningTranslationText($key)
    {
        return in_array($key, $this->translatedAttributes);
    }

    /**
     * Is the key locale?
     *
     * @param $key
     * @return bool
     */
    protected function isKeyALocale($key)
    {
        return in_array($key, $this->getLocales());
    }

    /**
     * Get available locales.
     *
     * @return mixed
     */
    protected function getLocales()
    {
        return \App::make('config')->get('app.locales', array());
    }

    /**
     * Save the translations.
     *
     * @return bool
     */
    protected function saveTranslations()
    {
        $saved = true;

        foreach ($this->translations as $translation) {

            if ($saved and $this->isTranslationDirty($translation)) {

                $translation->setAttribute($this->getRelationKey(), $this->getKey());

                $saved = $translation->save();

                $this->fireModelEvent('saved');
            }
        }

        return $saved;
    }

    /**
     * Is the translation dirty?
     *
     * @param $translation
     * @return bool
     */
    protected function isTranslationDirty($translation)
    {
        $dirtyAttributes = $translation->getDirty();

        unset($dirtyAttributes[$this->getLocaleKey()]);

        return count($dirtyAttributes) > 0;
    }

    /**
     * Return a new translation instance.
     *
     * @param $locale
     * @return mixed
     */
    protected function newTranslationInstance($locale)
    {
        $modelName = $this->getTranslationModelName();

        $translation = new $modelName;

        $translation->setAttribute($this->getLocaleKey(), $locale);
        $translation->setAttribute($this->getRelationKey(), $this->id);

        return $translation;
    }

    /**
     * The translations relationship.
     *
     * @return mixed
     */
    public function translations()
    {
        return $this->hasMany($this->getTranslationModelName(), $this->getRelationKey());
    }

    /**
     * Check if a key is set on the local or translated models.
     *
     * @param $key
     * @return bool
     */
    public function __isset($key)
    {
        return (in_array($key, $this->translatedAttributes) or parent::__isset($key));
    }
}
