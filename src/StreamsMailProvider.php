<?php namespace Anomaly\Streams\Platform;

use Anomaly\Streams\Platform\Mail\Mailer;
use Illuminate\Support\ServiceProvider;

/**
 * Class StreamsMailProvider
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\Streams\Platform
 */
class StreamsMailProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            'mailer',
            function () {

                $mailer = new Mailer(
                    $this->app['view'], $this->app['swift.mailer'], $this->app['events']
                );

                $mailer->setContainer($this->app);

                if ($this->app->bound('Psr\Log\LoggerInterface')) {
                    $mailer->setLogger($this->app->make('Psr\Log\LoggerInterface'));
                }

                if ($this->app->bound('queue')) {
                    $mailer->setQueue($this->app['queue.connection']);
                }

                $from = $this->app['config']['mail.from'];

                if (is_array($from) && isset($from['address'])) {
                    $mailer->alwaysFrom($from['address'], $from['name']);
                }

                $to = $this->app['config']['mail.to'];

                if (is_array($to) && isset($to['address'])) {
                    $mailer->alwaysTo($to['address'], $to['name']);
                }

                $pretend = $this->app['config']->get('mail.pretend', false);

                $mailer->pretend($pretend);

                return $mailer;
            }
        );

        $this->app->singleton(
            'Illuminate\Mail\Mailer',
            function () {
                return $this->app->make('mailer');
            }
        );

        $this->app->singleton(
            'Illuminate\Contracts\Mail\Mailer',
            function () {
                return $this->app->make('mailer');
            }
        );
    }
}
