<?php namespace Anomaly\Streams\Platform\Message;

use Illuminate\Session\Store;

/**
 * Class Message
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Message
 */
class Message
{

    /**
     * The session store.
     *
     * @var Store
     */
    protected $session;

    /**
     * Create a new Message instance.
     *
     * @param Store $session
     */
    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    /**
     * Add an error message.
     *
     * @param $message
     */
    public function error($message)
    {
        $this->merge(__FUNCTION__, $message);
    }

    /**
     * Add an info message.
     *
     * @param $message
     */
    public function info($message)
    {
        $this->merge(__FUNCTION__, $message);
    }

    /**
     * Add a success message.
     *
     * @param $message
     */
    public function success($message)
    {
        $this->merge(__FUNCTION__, $message);
    }

    /**
     * Add a warning message.
     *
     * @param $message
     */
    public function warning($message)
    {
        $this->merge(__FUNCTION__, $message);
    }

    /**
     * Merge a message onto the session.
     *
     * @param $type
     * @param $message
     */
    protected function merge($type, $message)
    {
        $messages = $this->session->get($type, []);

        if (is_array($message)) {
            $messages = array_merge($messages, $message);
        }

        if (is_string($message)) {
            array_push($messages, $message);
        }

        $this->session->set($type, $messages);
    }
}
