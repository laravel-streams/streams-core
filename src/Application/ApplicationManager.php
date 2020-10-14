<?php

namespace Streams\Core\Application;

use Streams\Core\Support\Traits\HasMemory;
use Illuminate\Support\Facades\App;

/**
 * Class ApplicationManager
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class ApplicationManager
{

    use HasMemory;

    /**
     * Make an application instance.
     *
     * @param string|null $handle
     * @return Application
     */
    public function make($handle = null)
    {
        if (!$handle) {
            return App::make('streams.application');
        }

        return App::make('streams.applications.' . $handle);
    }

    /**
     * Return the active application reference.
     *
     * @return string
     */
    public function handle()
    {
        return App::make('streams.application.handle');
    }

    /**
     * Switch the application.
     *
     * @todo does this work?
     *
     * @param string|null $handle
     */
    public function switch($handle = null)
    {
        if (!$handle) {

            $this->app->singleton('streams.application', function () {
                return $this->app->make('streams.application.origin');
            });

            $this->app->singleton('streams.application.handle', function () {
                return $this->app->make('streams.applications.origin')->handle;
            });
        }

        $this->app->singleton('streams.application', function () use ($handle) {
            return $this->app->make('streams.applications.' . $handle);
        });

        $this->app->singleton('streams.application.handle', function () use ($handle) {
            return $this->app->make('streams.applications.' . $handle)->handle;
        });
    }
}
