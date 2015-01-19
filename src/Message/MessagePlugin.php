<?php namespace Anomaly\Streams\Platform\Message;

use Anomaly\Streams\Platform\Addon\Plugin\Plugin;

/**
 * Class MessagePlugin
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Message
 */
class MessagePlugin extends Plugin
{

    /**
     * The message bag.
     *
     * @var Message
     */
    protected $messages;

    /**
     * Create a new MessagePlugin instance.
     *
     * @param Message $messages
     */
    public function __construct(Message $messages)
    {
        $this->messages = $messages;
    }

    /**
     * Get the plugin functions.
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('message_get', [$this->messages, 'get'])
        ];
    }
}
