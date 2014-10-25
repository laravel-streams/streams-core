<?php namespace Anomaly\Streams\Platform\Support;

use Illuminate\Session\Store;
use Illuminate\Support\MessageBag;

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