<?php

namespace Streams\Core\Support;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Console\Application;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;
use Streams\Core\Support\Facades\Assets;
use Streams\Core\Support\Facades\Streams;
use Illuminate\Console\Scheduling\Schedule;
use Streams\Core\Support\Traits\FiresCallbacks;

class Integrator
{

    use FiresCallbacks;

    public function integrate($details)
    {
        foreach ($details as $type => $payload) {
            $this->{$type}($payload);
        }
    }

    public function locale($locale)
    {
        App::setLocale($locale);
    }

    public function config($config)
    {
        Config::set(Arr::dot(Arr::parse($config)));
    }

    public function assets($assets)
    {
        foreach ($assets as $name => $assets) {
            Assets::register($name, $assets);
        }
    }

    public function aliases($aliases)
    {
        array_walk($aliases, function ($value, $key) {
            App::alias($key, $value);
        });
    }

    public function bindings($bindings)
    {
        array_walk($bindings, function ($value, $key) {
            App::bind($key, $value);
        });
    }

    public function singletons($singletons)
    {
        array_walk($singletons, function ($value, $key) {
            App::singleton($key, $value);
        });
    }

    public function commands($commands)
    {
        Application::starting(function ($artisan) use ($commands) {
            $artisan->resolveCommands($commands);
        });
    }

    public function listeners($listeners)
    {
        foreach ($listeners as $event => $classes) {

            foreach ($classes as $key => $listener) {

                $priority = 0;

                /**
                 * If the listener is an integer
                 * then the key is the listener
                 * and listener is priority.
                 */
                if (is_integer($listener)) {
                    $priority = $listener;
                    $listener = $key;
                }

                Event::listen($event, $listener, $priority);
            }
        }
    }
    
    public function policies($policies)
    {
        foreach ($policies as $model => $policy) {
            Gate::policy($model, $policy);
        }
    }

    public function routes($routes)
    {
        foreach ($routes as $group => $routes) {
            Route::middleware($group)->group(function () use ($routes) {
                foreach ($routes as $uri => $route) {
                    Route::streams($uri, $route);
                }
            });
        }
    }

    public function providers($providers)
    {
        foreach ($providers as $provider) {
            App::register($provider);
        }
    }

    public function schedules($schedules)
    {
        $schedule = App::make(Schedule::class);

        foreach ($schedules as $frequency => $commands) {

            foreach (array_filter($commands) as $command => $options) {

                /**
                 * If the option is a string
                 * then treat it as the command.
                 */
                if (is_string($options)) {
                    $command = $options;
                    $options = [];
                }

                /**
                 * If the frequency is a CRON
                 * expression then use that.
                 */
                if (Str::is('* * * *', $frequency)) {
                    $command = $schedule
                        ->command($command)
                        ->cron($frequency);
                }

                /**
                 * If the frequency is not a CRON
                 * expression then it's a method.
                 */
                if (!Str::is('* * * *', $frequency)) {

                    // Unpack {method}:{arg1},{arg2},...
                    $parts = explode(':', $frequency);

                    // First part is the method.
                    $method = Str::camel(array_shift($parts));

                    // The rest are arguments.
                    $arguments = explode(',', array_shift($parts));

                    // Use the method to create the command.
                    $command = call_user_func_array([
                        $schedule->command($command), $method
                    ], $arguments);
                }

                /**
                 * Loop over any options and chain them
                 * onto the command we just built.
                 * 
                 * Option keys are snake-cased to form
                 * the methods used to configure the command.
                 */
                foreach ($options as $option => $arguments) {

                    /**
                     * If the arguments are a string
                     * then treat them like the method
                     * and just run it with no arguments.
                     */
                    if (is_string($arguments)) {
                        $option    = $arguments;
                        $arguments = [];
                    }

                    $command = call_user_func_array([
                        $command, Str::camel($option)
                    ], (array) $arguments);
                }
            }
        }
    }

    public function middleware($middleware)
    {
        foreach ($middleware as $group => $middlewares) {
            foreach ($middlewares as $middleware) {
                Route::pushMiddlewareToGroup($group, $middleware);
            }
        }
    }

    public function streams($streams)
    {
        foreach ($streams as $handle => $stream) {

            Arr::set($stream, 'handle', Arr::get($stream, 'handle', $handle));

            Streams::register($stream);
        }
    }
}
