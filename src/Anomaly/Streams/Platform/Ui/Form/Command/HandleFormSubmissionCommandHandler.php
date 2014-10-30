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
     * @param HandleFormSubmissionCommand $command
     */
    public function handle(HandleFormSubmissionCommand $command)
    {
        $ui = $command->getUi();

        $entry = $ui->getEntry();

        app('streams.messages')->add('success', $entry->email . ' was saved.');

        app('streams.messages')->flash();

        return redirect(referer(url(app('request')->path())));
    }
}
 