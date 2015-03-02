<?php namespace Anomaly\Streams\Platform\Application;

use Anomaly\LocalizationModule\Language\Contract\LanguageInterface;
use Anomaly\Streams\Platform\Entry\EntryCollection;

/**
 * Class ApplicationPluginFunctions
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Application
 */
class ApplicationPluginFunctions
{

    /**
     * Return an environmental variable.
     *
     * @param      $key
     * @param null $default
     * @return mixed
     */
    public function env($key, $default = null)
    {
        return env($key, $default);
    }

    /**
     * Return available languages.
     *
     * @return null|EntryCollection
     */
    public function availableLocales()
    {
        if (env('INSTALLED')) {
            return app('Anomaly\LocalizationModule\Language\Contract\LanguageRepositoryInterface')->enabled();
        }

        return null;
    }

    /**
     * Return available languages.
     *
     * @return null|LanguageInterface
     */
    public function locale($iso)
    {
        if (env('INSTALLED')) {
            return app('Anomaly\LocalizationModule\Language\Contract\LanguageRepositoryInterface')->findByIso($iso);
        }

        return null;
    }
}
