<?php

namespace Anomaly\Streams\Platform\Provider\Concerns;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Events\ArtisanStarting;

/**
 * Trait ProvidesCommands
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
trait ProvidesCommands
{

    /**
     * Artisan commands.
     *
     * @var array
     */
    public $commands = [];

    /**
     * Register the Artisan commands.
     */
    protected function registerCommands()
    {
        if (!$this->commands) {
            return;
        }

        Event::listen(ArtisanStarting::class, function ($artisan) {
            $artisan->resolveCommands($this->commands);
        });
    }
}
