<?php namespace Anomaly\Streams\Platform\Installer;

use Closure;

/**
 * Class Installer
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Installer
 */
class Installer
{

    /**
     * The installation task.
     *
     * @var Closure
     */
    protected $task;

    /**
     * The output message.
     *
     * @var string
     */
    protected $message;

    /**
     * Create a new Installer instance.
     *
     * @param          $message
     * @param callable $task
     */
    function __construct($message, Closure $task)
    {
        $this->task    = $task;
        $this->message = $message;
    }

    /**
     * Get the message.
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Get the task.
     *
     * @return callable
     */
    public function getTask()
    {
        return $this->task;
    }
}
