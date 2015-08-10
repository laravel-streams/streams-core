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
        $locales = require __DIR__ . '/../../resources/config/locales.php';

        $pattern = '/^\/(' . implode('|', array_keys($locales['supported'])) . ')\//';

        $uri = filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL);

        if (preg_match($pattern, $uri, $matches)) {

            $_SERVER['ORIGINAL_REQUEST_URI'] = $uri;
            $_SERVER['REQUEST_URI']          = preg_replace($pattern, '/', $uri);

            define('LOCALE', $matches[1]);
        }
    }
}
