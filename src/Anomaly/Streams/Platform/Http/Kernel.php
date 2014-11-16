<?php namespace Anomaly\Streams\Platform\Http;

class Kernel extends \Illuminate\Foundation\Http\Kernel
{

    /**
     * The application's HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        'Illuminate\Cookie\Middleware\EncryptCookies',
        'Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse',
        'Illuminate\Session\Middleware\StartSession',
        'Illuminate\View\Middleware\ShareErrorsFromSession',
        'Anomaly\Streams\Platform\Http\Middleware\FlashMessagesMiddleware',
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
 