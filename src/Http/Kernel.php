<?php namespace Anomaly\Streams\Platform\Http;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Routing\Router;

/**
 * Class Kernel
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Http
 */
class Kernel extends \App\Http\Kernel
{

    /**
     * Create a new Kernel instance.
     *
     * @param Application $app
     * @param Router      $router
     */
    public function __construct(Application $app, Router $router)
    {
        $this->defineLocale();

        parent::__construct($app, $router);
    }

    /**
     * Define the locale
     * based on our URI.
     *
     * Huge thanks to @keevitaja for this one.
     *
     * @link https://github.com/keevitaja/linguist
     */
    protected function defineLocale()
    {

        /**
         * First grab the supported i18n locales
         * that we should be looking for.
         */
        $locales = require __DIR__ . '/../../resources/config/locales.php';

        if (file_exists($override = __DIR__ . '/../../../../../resources/core/config/streams/locales.php')) {
            $locales = array_replace_recursive($locales, require $override);
        }

        if (!$hint = array_get($locales, 'hint')) {
            return;
        }

        /**
         * Check the domain for a locale.
         */
        $url  = parse_url(array_get($_SERVER, 'HTTP_HOST', env('APPLICATION_DOMAIN')));
        $host = array_get($url, 'host');

        $pattern = '/^(' . implode('|', array_keys($locales['supported'])) . ')(\.)./';

        if ($host && ($hint === 'domain' || $hint === true) && preg_match($pattern, $host, $matches)) {

            define('LOCALE', $matches[1]);

            return;
        }

        /**
         * Let's first look in the URI
         * path for for a locale.
         */
        $pattern = '/^\/(' . implode('|', array_keys($locales['supported'])) . ')\//';

        $uri = filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL);

        if (($hint === 'uri' || $hint === true) && preg_match($pattern, $uri, $matches)) {

            $_SERVER['ORIGINAL_REQUEST_URI'] = $uri;
            $_SERVER['REQUEST_URI']          = preg_replace($pattern, '/', $uri);

            define('LOCALE', $matches[1]);

            return;
        }

        /**
         * Check if we're on the home page.
         */
        $pattern = '/^\/(' . implode('|', array_keys($locales['supported'])) . ')$/';

        $uri = filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL);

        if (($hint === 'uri' || $hint === true) && preg_match($pattern, $uri, $matches)) {

            $_SERVER['ORIGINAL_REQUEST_URI'] = $uri;
            $_SERVER['REQUEST_URI']          = preg_replace($pattern, '/', $uri);

            define('LOCALE', $matches[1]);

            return;
        }
    }
}
