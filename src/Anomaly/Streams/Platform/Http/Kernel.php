<?php namespace Anomaly\Streams\Platform\Http;

/**
 * Class Kernel
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Http
 */
class Kernel extends \Illuminate\Foundation\Http\Kernel
{

    /**
     * The application's HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        'Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode',
        'Illuminate\Cookie\Middleware\EncryptCookies',
        'Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse',
        'Illuminate\Session\Middleware\StartSession',
        'Illuminate\View\Middleware\ShareErrorsFromSession',
        'Illuminate\Foundation\Http\Middleware\VerifyCsrfToken',
        //'Anomaly\Streams\Platform\Http\Middleware\CheckInstallation',
        'Anomaly\Streams\Platform\Http\Middleware\SetLocale',
        'Anomaly\Streams\Platform\Http\Middleware\FlashMessages',
    ];

    /**
     * Handle an incoming HTTP request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function handle($request)
    {
        try {

            return parent::handle($request);
        } catch (\Exception $e) {

            throw $e;
        }
    }
}
 