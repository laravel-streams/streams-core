<?php

namespace Anomaly\Streams\Platform\Addon\FieldType\Concerns;

use Illuminate\Support\Collection;

/**
 * Trait HasLocale
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
trait HasLocale
{

    /**
     * The field's input locale.
     *
     * @var null|string
     */
    public $locale = null;

    /**
     * Set the locale.
     *
     * @param  $locale
     * @return $this
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Get the locale.
     *
     * @return null|string
     */
    public function getLocale()
    {
        return $this->locale;
    }
}
