<?php

namespace Anomaly\Streams\Platform\Model\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Anomaly\Streams\Platform\Model\EloquentCollection;

/**
 * Class Translatable
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
trait Translatable
{

    /**
     * The translatable attributes.
     *
     * @var array
     */
    protected $translatedAttributes = [];

    /**
     * Return translated attributes.
     *
     * @return array
     */
    public function getTranslatedAttributes()
    {
        return $this->translatedAttributes;
    }

    /**
     * Return if the attribute is
     * translatable or not.
     *
     * @param $key
     * @return bool
     */
    public function isTranslatedAttribute($key)
    {
        return in_array($key, $this->getTranslatedAttributes());
    }

    /**
     * Return the translatable flag.
     *
     * @return bool
     */
    public function isTranslatable()
    {
        return !empty($this->getTranslatedAttributes());
    }

    /*
     * Change the instance locale
     * so that subsequent attribute
     * fetch methods use the new locale.
     *
     * @return $this
     */
    public function translate($locale = null)
    {
        throw new \Exception('translate() method missing logic.');
        //return $this->getTranslatedAttribute($key, $locale ?: app()->getLocale());
    }
}
