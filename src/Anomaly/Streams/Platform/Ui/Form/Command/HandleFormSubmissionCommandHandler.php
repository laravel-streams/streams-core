<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Illuminate\Http\Request;

class HandleFormSubmissionCommandHandler
{

    protected $request;

    function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function handle(HandleFormSubmissionCommandHandler $command)
    {
        die('Handling that form sucka!');
    }

}
 