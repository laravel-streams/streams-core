<?php

namespace Anomaly\Streams\Platform\Message;

use Illuminate\Session\Store;

/**
 * Class MessageManger
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class MessageManger
{

    /**
     * The session store.
     *
     * @var Store
     */
    protected $session;

    /**
     * Create a new MessageManger instance.
     *
     * @param Store $session
     */
    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    /**
     * Add a message.
     *
     * @param $type
     * @param $message
     * @return MessageManger
     */
    public function add($type, $message)
    {
        if (is_string($message)) {
            $message = [
                'type' => $type,
                'content' => $message,
            ];
        }
        
        return $this->merge(md5(json_encode($message)), $message);
    }

    /**
     * Merge a message onto the session.
     *
     * @param $type
     * @param $message
     * @return $this
     */
    protected function merge(string $key, $message)
    {
        $messages = $this->session->get('messages', []);

        $messages = array_merge($messages, [$key => $message]);

        $this->session->put('messages', $messages);

        return $this;
    }

    /**
     * Get messages.
     *
     * @param array $default
     * @return array
     */
    public function get(array $default = [])
    {
        return $this->session->get('messages', $default);
    }

    /**
     * Pull the messages.
     *
     * @param array $default
     * @return array
     */
    public function pull(array $default = [])
    {
        return $this->session->pull('messages', $default);
    }

    /**
     * Add an error message.
     *
     * @param $message
     * @return $this
     */
    public function error($message)
    {
        $this->add(__FUNCTION__, $message);

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
        $this->add(__FUNCTION__, $message);

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
        $this->add(__FUNCTION__, $message);

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
        $this->add(__FUNCTION__, $message);

        return $this;
    }

    /**
     * Add an important message.
     *
     * @param $message
     * @return $this
     */
    public function important($message)
    {
        $this->add(__FUNCTION__, $message);

        return $this;
    }

    /**
     * Flush the messages.
     *
     * @return $this
     */
    public function flush()
    {
        $this->session->forget('messages');

        return $this;
    }
}
