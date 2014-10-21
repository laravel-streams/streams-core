<?php namespace Anomaly\Streams\Platform\Provider;

use Illuminate\Routing\Router;
use Illuminate\Routing\Stack\Builder;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;

class MiddlewareServiceProvider extends RouteServiceProvider
{
    /**
     * All of the application's route middleware keys.
     *
     * @var array
     */
    protected $middleware = [
        'auth' => 'Anomaly\Streams\Platform\Http\Middleware\AuthMiddleware',
        'csrf' => 'Anomaly\Streams\Platform\Http\Middleware\CsrfMiddleware',
    ];

    /**
     * The application's middleware stack.
     *
     * @var array
     */
    protected $stack = [
        'Anomaly\Streams\Platform\Http\Middleware\LocaleMiddleware',
        'Anomaly\Streams\Platform\Http\Middleware\InstallerMiddleware',
    ];

    public function before()
    {
    }

    /**
     * Build the application stack based on the provider properties.
     *
     * @return void
     */
    public function stack()
    {
        $this->app->stack(
            function (Builder $stack, Router $router) {
                return $stack->middleware($this->stack)->then(
                    function ($request) use ($router) {
                        return $router->dispatch($request);
                    }
                );
            }
        );
    }
}
