<?php namespace Streams\Platform\Traits;

use Illuminate\Database\Eloquent\MassAssignmentException;

trait TranslatableTrait
{
    /**
     * Alias for getTranslation()
     */
    public function translate($locale = null, $defaultLocale = null)
    {
        return $this->getTranslation($locale, $defaultLocale);
    }

    /**
     * Alias for getTranslation()
     */
    public function translateOrDefault($locale)
    {
        return $this->getTranslation($locale, true);
    }

    /**
     * Get translation of model.
     *
     * @param null $locale
     * @param bool $withFallback
     * @return null
     */
    public function getTranslation($locale = null, $withFallback = false)
    {
        $locale       = $locale ? : \App::getLocale();
        $withFallback = isset($this->useTranslationFallback) ? $this->useTranslationFallback : $withFallback;

        if ($this->getTranslationByLocaleKey($locale)) {
            $translation = $this->getTranslationByLocaleKey($locale);
        } elseif ($withFallback
            and \App::make('config')->has('app.fallback_locale')
            and $this->getTranslationByLocaleKey(\App::make('config')->get('app.fallback_locale'))
        ) {
            $translation = $this->getTranslationByLocaleKey(\App::make('config')->get('app.fallback_locale'));
        } else {
            $translation = $this->newTranslationInstance($locale);
            $this->translations->add($translation);
        }

        return $translation;
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
     * Save the model.
     *
     * @param array $options
     * @return bool
     */
    public function save(array $options = array())
    {
        if ($this->exists) {
            if (count($this->getDirty()) > 0) {
                if (parent::save($options)) {
                    return $this->saveTranslations();
                }

                return false;
            } else {
                return $this->saveTranslations();
            }
        } elseif (parent::save($options)) {
            return $this->saveTranslations();
        }

        return false;
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
