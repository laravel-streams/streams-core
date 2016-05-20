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
        list($namespace, $path) = explode('::', str_replace('/', '.', $view));

        /**
         * If the message is in the message directory
         * then we can assume they want to translate it.
         */
        if (starts_with($path, 'message.')) {

            $locale = config('app.locale');

            if (str_is('*.*.*', $path)) {
                list($directory, $locale, $message) = explode('.', $path);
            } else {
                list($directory, $message) = explode('.', $path);
            }

            /**
             * Try sending it in the current locale or the
             * locale specified in the data path.
             */
            $view = "{$namespace}::{$directory}.{$locale}.{$message}";

            if ($this->views->exists($view)) {
                return parent::send($view, $data, $callback);
            }

            /**
             * In the event that the locale is not available
             * the fallback locale must be used.
             */
            $locale = config('app.fallback_locale');

            $view = "{$namespace}::{$directory}.{$locale}.{$message}";

            if ($this->views->exists($view)) {
                return parent::send($view, $data, $callback);
            }

            return parent::send($namespace . '::' . $path, $data, $callback);
        }

        return parent::send($view, $data, $callback);
    }

}
