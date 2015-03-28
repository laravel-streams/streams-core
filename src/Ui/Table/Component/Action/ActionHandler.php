<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Action;

use Anomaly\Streams\Platform\Message\MessageBag;

/**
 * Class ActionHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Action
 */
abstract class ActionHandler
{

    /**
     * The message bag.
     *
     * @var MessageBag
     */
    protected $messages;

    /**
     * Create a new ActionHandler instance.
     *
     * @param MessageBag $messages
     */
    public function __construct(MessageBag $messages)
    {
        $this->messages = $messages;
    }
}
