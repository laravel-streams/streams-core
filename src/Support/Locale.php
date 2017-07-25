<?php namespace Anomaly\Streams\Platform\Support;

/**
 * Class Locale
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Locale
{

    protected $locale;

    /**
     * Create a new Locale instance.
     *
     * @param $locale
     */
    public function __construct($locale = null)
    {
        $this->locale = $locale ?: config('app.locale');
    }

    /**
     * Return if the locale is RTL.
     *
     * @return bool
     */
    public function isRtl()
    {
        return config('streams::locales.supported.' . $this->locale . '.direction') == 'rtl';
    }

    /**
     * Return the locale name.
     *
     * @return bool
     */
    public function name()
    {
        return 'streams::locale.' . $this->locale . '.name';
    }

    /**
     * Return the locale.
     *
     * @return string
     */
    function __toString()
    {
        return (string)$this->locale;
    }
}
