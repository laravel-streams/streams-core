<?php namespace Anomaly\Streams\Platform\Message;

use Illuminate\Session\Store;

/**
 * Class MessageBag
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\MessageBag
 */
class MessageBag
{

    /**
     * The session store.
     *
     * @var Store
     */
    protected $session;

    /**
     * Create a new MessageBag instance.
     *
     * @param Store $session
     */
    public function __construct(Store $session)
    {
        $this->session = $session;
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

        $messages = array_unique($messages);

        $this->session->set($type, $messages);
    }

    /**
     * Add an error message.
     *
     * @param $message
     * @return $this
     */
    public function error($message)
    {
        $this->merge(__FUNCTION__, $message);

        return $this;
    }

    /**
     * Add an info message.
     *
     * @param $message
     * @return $this
     */
    public function info($message)
    {
        $this->merge(__FUNCTION__, $message);

        return $this;
    }

    /**
     * Add a success message.
     *
     * @param $message
     * @return $this
     */
    public function success($message)
    {
        $this->merge(__FUNCTION__, $message);

        return $this;
    }

    /**
     * Add a warning message.
     *
     * @param $message
     * @return $this
     */
    public function warning($message)
    {
        $this->merge(__FUNCTION__, $message);

        return $this;
    }

    /**
     * Flush the messages.
     *
     * @return $this
     */
    public function flush()
    {
        $this->session->forget('info');
        $this->session->forget('error');
        $this->session->forget('success');
        $this->session->forget('warning');

        return $this;
    }
}
