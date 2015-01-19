<?php namespace Anomaly\Streams\Platform\Message;

use Illuminate\Session\Store;
use Illuminate\Support\MessageBag;

/**
 * Class Message
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Message
 */
class Message extends MessageBag
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
     * @param array $messages
     */
    public function __construct(Store $session, array $messages = [])
    {
        $this->session = $session;

        if ($session->has('messages')) {
            $messages = array_merge_recursive($session->get('messages'), $messages);
        }

        parent::__construct($messages);
    }

    /**
     * Flash the messages.
     *
     * @return $this
     */
    public function flash()
    {
        $this->session->flash('messages', $this->messages);

        return $this;
    }
}
