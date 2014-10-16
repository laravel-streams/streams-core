<?php namespace Streams\Platform\Provider;

use Illuminate\Routing\Router;
use Illuminate\Routing\Stack\Builder;
use Illuminate\Foundation\Support\Providers\AppServiceProvider;

class MiddlewareServiceProvider extends AppServiceProvider
{
    /**
     * All of the application's route middleware keys.
     *
     * @var array
     */
    protected $middleware = [
        'auth' => 'Streams\Platform\Http\Middleware\AuthMiddleware',
        'csrf' => 'Streams\Platform\Http\Middleware\CsrfMiddleware',
    ];

    /**
     * The application's middleware stack.
     *
     * @var array
     */
    protected $stack = [
        'Streams\Platform\Http\Middleware\LocaleMiddleware',
        'Streams\Platform\Http\Middleware\InstallerMiddleware',
    ];

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
