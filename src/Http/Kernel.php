<?php namespace Anomaly\Streams\Platform\Http;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;

/**
 * Class Kernel
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Kernel extends \Illuminate\Foundation\Http\Kernel
{

    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Cookie\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \Anomaly\Streams\Platform\Http\Middleware\SetLocale::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'can'        => \Illuminate\Auth\Middleware\Authorize::class,
        'auth'       => \Illuminate\Auth\Middleware\Authenticate::class,
        'throttle'   => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'bindings'   => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        //'guest' => \Illuminate\Auth\Middleware\RedirectIfAuthenticated::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * Create a new Kernel instance.
     *
     * @param Application $app
     * @param Router      $router
     */
    public function __construct(Application $app, Router $router)
    {
        $config = require base_path('config/streams.php');

        $middleware         = array_get($config, 'middleware', []);
        $routeMiddleware    = array_get($config, 'route_middleware', []);
        $middlewareGroups   = array_get($config, 'middleware_groups', []);
        $middlewarePriority = array_get($config, 'middleware_priority', []);

        $this->middleware         = array_merge($this->middleware, $middleware);
        $this->routeMiddleware    = array_merge($this->routeMiddleware, $routeMiddleware);
        $this->middlewareGroups   = array_merge($this->middlewareGroups, $middlewareGroups);
        $this->middlewarePriority = array_merge($this->middlewarePriority, $middlewarePriority);

        parent::__construct($app, $router);
    }

    /**
     * Handle an incoming HTTP request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request)
    {
        $this->defineLocale($request);
        $this->rewriteAdmin($request);

        return parent::handle($request);
    }

    /**
     * Define the locale
     * based on our URI.
     *
     * Huge thanks to @keevitaja for this one.
     *
     * @link https://github.com/keevitaja/linguist
     */
    protected function defineLocale(Request $request)
    {
        /*
         * Make sure the ORIGINAL_REQUEST_URI is always available
         * Overwrite later as necessary
         */
        $request->server->set(
            'ORIGINAL_REQUEST_URI',
            $originalRequestUri = $request->getRequestUri();
        );

        /*
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

        /*
         * Check the domain for a locale.
         */
        $url = parse_url($request->getHost());

        if ($url === false) {
            throw new \Exception('Malformed URL: ' . $url);
        }

        $host = array_get($url, 'host');

        $pattern = '/^(' . implode('|', array_keys($locales['supported'])) . ')(\.)./';

        if ($host && ($hint === 'domain' || $hint === true) && preg_match($pattern, $host, $matches)) {

            define('LOCALE', $matches[1]);

            return;
        }

        /*
         * Let's first look in the URI
         * path for for a locale.
         */
        $pattern = '/^\/(' . implode('|', array_keys($locales['supported'])) . ')(\/|(?:$)|(?=\?))/';

        if (($hint === 'uri' || $hint === true) && preg_match($pattern, $originalRequestUri, $matches)) {
            $request->server->set('REQUEST_URI', preg_replace($pattern, '/', $originalRequestUri));
            $request->initialize(
                $request->query->all(), 
                $request->request->all(), 
                $request->attributes->all(), 
                $request->cookies->all(), 
                $request->files->all(), 
                $request->server->all(), 
                $request->getContent()
            );
            define('LOCALE', $matches[1]);
            return;
        }

    }

    /**
     * Rewrite the admin URI based on
     * configured admin URI segment.
     */
    protected function rewriteAdmin(Request $request)
    {
        // Our admin segment.
        $segment = 'admin';

        /**
         * Skip if our admin
         * segment is admin.
         */
        if ($segment == 'admin') {
            return;
        }

        /**
         * If we have a configured admin
         * slug then make sure we are not
         * accessing the original segment.
         */
        $pattern = '/^\/(admin)(?=\/?)/';

        $uri = $request->getRequestUri();

        if (preg_match($pattern, $uri, $matches)) {
            abort(404);
        }

        /**
         * Now rewrite the admin segment
         * based on the configured value.
         */
        $pattern = '/^\/(' . $segment . ')(?=\/?)/';
        if (preg_match($pattern, $uri, $matches)) {
            $request->server->set('REQUEST_URI', preg_replace($pattern, '/admin', $uri));
            $request->initialize(
                $request->query->all(), 
                $request->request->all(), 
                $request->attributes->all(), 
                $request->cookies->all(), 
                $request->files->all(), 
                $request->server->all(), 
                $request->getContent()
            );
        }
    }
}
