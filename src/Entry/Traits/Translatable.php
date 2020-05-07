<?php

namespace Anomaly\Streams\Platform\Entry\Traits;

use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Illuminate\Database\Eloquent\Relations\HasMany;


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
     * The translating locale.
     *
     * @var null|string
     */
    public $locale = null;

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
        return $this->stream->fields->get($key)->translatable;
    }

    /**
     * Return the translatable flag.
     *
     * @return bool
     */
    public function isTranslatable()
    {
        return $this->stream->fields->translatable()->isNotEmpty();
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
        $this->locale = $locale ?: App::getLocale();

        return $this;
    }

    /**
     * Return the translating locale.
     *
     * @param string|null $default
     */
    public function locale($default = null)
    {
        return $this->locale ?: ($default ?: App::getLocale());
    }
}
