<?php namespace Anomaly\Streams\Platform\Mail\Command;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Application;

/**
 * Class RegisterMailer
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\Streams\Platform\Mail\Command
 */
class RegisterMailer implements SelfHandling
{

    /**
     * Handle the command.
     *
     * @param Application $application
     */
    public function handle(Application $application)
    {

        /**
         * First we have to trigger
         * the mailer to resolve in
         * the first place.
         */
        $application->make('mailer');

        /**
         * Now we can bind our own mailer.
         */
        $application->register('Anomaly\Streams\Platform\StreamsMailProvider');
    }
}
