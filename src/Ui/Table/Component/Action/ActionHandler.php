<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Action;

use Anomaly\Streams\Platform\Ui\Table\Table;
use Illuminate\Http\Request;

/**
 * Class ActionHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Action
 */
class ActionHandler
{

    /**
     * The request object.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Create a new ActionHandler instance.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the form response.
     *
     * @param Table $form
     */
    public function handle(Table $form)
    {
    }
}
