<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Illuminate\Http\Request;

/**
 * Class HandleFormSubmissionCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class HandleFormSubmissionCommandHandler
{

    /**
     * The HTTP request object.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Create a new HandleFormSubmissionCommandHandler instance.
     *
     * @param Request $request
     */
    function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the command.
     *
     * @param HandleFormSubmissionCommandHandler $command
     */
    public function handle(HandleFormSubmissionCommandHandler $command)
    {
        die('Handling that form sucka!');
    }

}
 