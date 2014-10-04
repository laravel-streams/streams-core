<?php namespace Streams\Platform\Provider;

use Cartalyst\Sentry\Sentry;
use Cartalyst\Sentry\SentryServiceProvider;

class AuthServiceProvider extends SentryServiceProvider
{
    /**
     * Takes all the components of Sentry and glues them
     * together to create Sentry under "auth".
     *
     * @return void
     */
    protected function registerSentry()
    {
        $this->app['auth'] = $this->app['sentry'] = $this->app->share(
            function ($app) {
                return new Sentry(
                    $app['sentry.user'],
                    $app['sentry.group'],
                    $app['sentry.throttle'],
                    $app['sentry.session'],
                    $app['sentry.cookie'],
                    $app['request']->getClientIp()
                );
            }
        );
    }
}
