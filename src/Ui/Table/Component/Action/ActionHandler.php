<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Action;

use Anomaly\Streams\Platform\Message\MessageManager;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class ActionHandler
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
abstract class ActionHandler
{
    use DispatchesJobs;

    /**
     * The message bag.
     *
     * @var MessageManager
     */
    protected $messages;

    /**
     * Create a new ActionHandler instance.
     *
     * @param MessageManager $messages
     */
    public function __construct(MessageManager $messages)
    {
        $this->messages = $messages;
    }
}
