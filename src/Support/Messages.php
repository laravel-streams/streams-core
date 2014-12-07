<?php namespace Anomaly\Streams\Platform\Support;

use Illuminate\Session\Store;
use Illuminate\Support\MessageBag;

/**
 * Class Messages
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Support
 */
class Messages extends MessageBag
{

    /**
     * The session key for our session store.
     *
     * @var string
     */
    protected $sessionKey = 'messages';

    /**
     * The session store object.
     *
     * @var Store
     */
    protected $session;

    /**
     * Add one or more messages to a key.
     *
     * @param string       $key
     * @param array|string $message
     * @return $this
     */
    public function add($key, $message)
    {
        if (is_array($message) and $messages = $message) {

            foreach ($messages as $message) {

                parent::add($key, $message);
            }

            return $this;
        }

        return parent::add($key, $message);
    }

    /**
     * Flash the messages for a redirect.
     *
     * @return $this
     */
    public function flash()
    {
        app('session')->flash($this->sessionKey, $this->messages);

        return $this;
    }
}