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
     * Create a new Messages instance.
     *
     * @param Store $session
     * @param array $messages
     */
    public function __construct(Store $session, $messages = [])
    {
        $this->session = $session;

        if ($session->has($this->sessionKey)) {
            $messages = array_merge_recursive($session->get($this->sessionKey), $messages);
        }

        parent::__construct($messages);
    }

    /**
     * Flash the messages for a redirect.
     *
     * @return $this
     */
    public function flash()
    {
        $this->session->flash($this->sessionKey, $this->messages);

        return $this;
    }
}