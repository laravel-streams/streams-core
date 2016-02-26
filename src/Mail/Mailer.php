<?php namespace Anomaly\Streams\Platform\Mail;

/**
 * Class Mailer
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Mail
 */
class Mailer extends \Illuminate\Mail\Mailer
{

    /**
     * Send a new message using a view.
     *
     * @param  string|array    $view
     * @param  array           $data
     * @param  \Closure|string $callback
     * @return mixed
     */
    public function send($view, array $data, $callback)
    {

        /**
         * Split the view into it's
         * namespace and path.
         */
        list($namespace, $path) = explode('::', $view);

        $path = str_replace('.', '/', $path);

        /**
         * Catch the emails first.
         */
        if (starts_with($path, 'emails/')) {

            $email = $namespace . '::' . str_replace('emails/', config('LOCALE', 'en') . 'emails/', $path);

            if ($this->views->exists($email)) {
                $view = $email;
            } else {
                $view = $namespace . '::' . str_replace('emails/', 'emails/en/', $path);
            }
        }

        return parent::send($view, $data, $callback);
    }

}
