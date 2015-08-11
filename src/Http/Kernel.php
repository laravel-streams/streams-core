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

        if (file_exists($override = __DIR__ . '/../../../../../config/streams/locales.php')) {
            $locales = array_merge_recursive($locales, require $override);
        }

        if (!$hint = array_get($locales, 'hint')) {
            return;
        }

        /**
         * Let's first look in the URI
         * path for for a locale.
         */
        $pattern = '/^\/(' . implode('|', array_keys($locales['supported'])) . ')\//';

        $uri = filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL);

        if ($hint === 'uri' && preg_match($pattern, $uri, $matches)) {

            $_SERVER['ORIGINAL_REQUEST_URI'] = $uri;
            $_SERVER['REQUEST_URI']          = preg_replace($pattern, '/', $uri);

            define('LOCALE', $matches[1]);

            return;
        }

        $url = parse_url($_SERVER['HTTP_HOST']);

        $pattern = '/^(' . implode('|', array_keys($locales['supported'])) . ')./';

        if ($hint === 'domain' && preg_match($pattern, $url['host'], $matches)) {

            define('LOCALE', $matches[1]);

            return;
        }
    }
}
