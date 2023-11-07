<?php

namespace Streams\Core\Support;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Console\Application;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Config;
use Streams\Core\Support\Facades\Assets;
use Streams\Core\Support\Facades\Streams;
use Illuminate\Console\Scheduling\Schedule;
use Streams\Core\Support\Facades\Includes;
use Streams\Core\Support\Facades\Overrides;
use Streams\Core\Support\Traits\FiresCallbacks;

class Integrator
{

    use FiresCallbacks;

    public static function integrate(array $details): void
    {
        foreach ($details as $type => $payload) {
            static::{$type}($payload);
        }
    }

    public static function locale(string $locale): void
    {
        App::setLocale($locale);
    }

    public static function config(array $config): void
    {
        Config::set(Arr::parse(Arr::dot($config)));
    }

    public static function assets(array $assets): void
    {
        foreach ($assets as $name => $assets) {
            Assets::register($name, $assets);
        }
    }

    public static function aliases(array $aliases): void
    {
        array_walk($aliases, function ($value, $key) {
            App::alias($value, $key);
        });
    }

    public static function bindings(array $bindings): void
    {
        array_walk($bindings, function ($value, $key) {
            App::bind($key, $value);
        });
    }

    public static function singletons(array $singletons): void
    {
        array_walk($singletons, function ($value, $key) {
            App::singleton($key, $value);
        });
    }

    public static function commands(array $commands): void
    {
        Application::starting(function ($artisan) use ($commands) {
            $artisan->resolveCommands($commands);
        });
    }

    public static function listeners(array $listeners): void
    {
        foreach ($listeners as $event => $classes) {

            foreach ($classes as $listener) {
                Event::listen($event, $listener);
            }
        }
    }

    public static function policies(array $policies): void
    {
        foreach ($policies as $key => $policy) {

            if (!class_exists($key)) {

                Gate::define($key, $policy);

                continue;
            }

            Gate::policy($key, $policy);
        }
    }

    public static function routes(array $routes): void
    {
        foreach ($routes as $group => $routes) {
            Route::middleware($group)->group(function () use ($routes) {
                foreach ($routes as $uri => $route) {
                    Route::streams($uri, $route);
                }
            });
        }
    }

    public static function providers(array $providers): void
    {
        foreach ($providers as $provider) {
            App::register($provider);
        }
    }

    public static function schedules(array $schedules): void
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

    public static function middleware(array $middleware): void
    {
        foreach ($middleware as $group => $middlewares) {
            foreach ($middlewares as $middleware) {
                Route::pushMiddlewareToGroup($group, $middleware);
            }
        }
    }

    public static function streams(array $streams): void
    {
        foreach ($streams as $key => $stream) {

            if (is_string($stream)) {
                Streams::load($stream);
            }

            if (is_array($stream)) {

                $keyName = Arr::get($stream, 'config.key_name', 'id');

                $key = Arr::pull($stream, $keyName, $key);

                Streams::register(array_merge($stream, [$keyName => $key]));
            }
        }
    }

    public static function includes(array $includes): void
    {
        foreach ($includes as $slot => $views) {
            foreach ($views as $include) {
                Includes::include($slot, $include);
            }
        }
    }

    public static function overrides(array $overrides): void
    {
        foreach ($overrides as $view => $override) {
            Overrides::put($view, $override);
        }
    }
}
