<?php namespace Anomaly\Streams\Platform\Message;

use Anomaly\Streams\Platform\Addon\Plugin\Plugin;
use Illuminate\Session\Store;

/**
 * Class MessagePlugin
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\MessageBag
 */
class MessagePlugin extends Plugin
{

    /**
     * The session store.
     *
     * @var Store
     */
    protected $session;

    /**
     * Create a new MessagePlugin instance.
     *
     * @param Store $session
     */
    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    /**
     * Get the plugin functions.
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('message_exists', [$this->session, 'has']),
            new \Twig_SimpleFunction('message_get', [$this->session, 'pull'])
        ];
    }
}
