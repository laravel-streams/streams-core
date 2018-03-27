<?php namespace Anomaly\Streams\Platform\Addon\Command;

use Illuminate\Routing\Router;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Anomaly\Streams\Platform\Addon\Addon;

class RegisterAddonRouter
{
	/**
	 * The need register routes.
	 *
	 * @var array
	 */
	protected $routes = [];

	/**
	 * The addon instance.
	 *
	 * @var Addon
	 */
	protected $addon;

	/**
	 * The namespaces for your controller routing.
	 *
	 * @var	string
	 */
	protected $namespace;

	/**
	 * Create an a new RegisterAddonRouter.
	 *
	 * @param  array  $routes
	 * @param  Addon  $addon
	 * @param  string $namespace
	 *
	 * @return void
	 */
	public function __countruct(array $routes, Addon $addon, string $namespace = '')
	{
		$this->routes = $routes;
		$this->addon = $addon;
		$this->namespace = $namespace;
	}

	/**
	 * The handle the command.
	 *
	 * @param Router $router
	 */
	public function handle(Router $router)
	{
		foreach ( $this->routes as $uri => $route ) {

			// If the route definition is an not an array then let's make it one.
			// Array type routes give us more control and allow us to pass information
			// in the request's route action array.
			if ( ! is_array($route) )
			{
				$route = [
					'uses' => $route,
				];
			}
			$route['uses'] = $this->namespace . $route['uses'];

			$verb = Arr::pull($route, 'verb', 'any');

			$middleware = Arr::pull($route, 'middleware', []);

			$constraints = Arr::pull($route, 'constraints', []);

			Arr::set($route, 'streams::addon', $this->addon->getNamespace());

			if ( is_string($route['uses']) && ! Str::contains($route['uses'], '@') ) {

				$router->resource($uri, $route['uses']);

			} else {

				$route = $router->{$verb}($uri, $route)->where($constraints);

				if ( $middleware ) {
					call_user_func_array([$route, 'middleware'], (array) $middleware);
				}
			}
		}
	}
}
