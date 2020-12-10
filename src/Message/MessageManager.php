<?php

namespace Streams\Core\Message;

use Illuminate\Session\Store;

/**
 * Class MessageManager
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class MessageManager
{

    /**
     * The session store.
     *
     * @var Store
     */
    protected $session;

    /**
     * Create a new MessageManager instance.
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
     * @return MessageManager
     */
    public function add($type, $message)
    {
        if (is_string($message)) {
            $message = [
                'content' => $message,
            ];
        }

        $message['type'] = $type;
        
        return $this->merge(md5(json_encode($message)), $message);
    }

    /**
     * Merge a message onto the session.
     *
     * @param string $type
     * @param array $message
     * @return $this
     */
    protected function merge(string $key, array $message)
    {
        $messages = $this->session->get('messages', []);

        $messages = array_merge($messages, [$key => $message]);

        $this->session->flash('messages', $messages);

        return $this;
    }

    /**
     * Get messages.
     *
     * @return array
     */
    public function get()
    {
        return $this->session->get('messages', []);
    }

    /**
     * Pull the messages.
     *
     * @return array
     */
    public function pull()
    {
        return $this->session->pull('messages', []);
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
     * Add a danger message.
     *
     * @param $message
     * @return $this
     */
    public function danger($message)
    {
        $this->add(__FUNCTION__, $message);

        return $this;
    }

    /**
     * Add a important message.
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
