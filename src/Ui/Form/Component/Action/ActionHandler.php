<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Action;

use Anomaly\Streams\Platform\Ui\Form\Form;
use Illuminate\Http\Request;

/**
 * Class ActionHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Action
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
     * @param Form $form
     */
    public function handle(Form $form)
    {
        $action = $form->getActions()->active();

        $url = $action->getRedirect();

        /**
         * If the URL is null then use the current one.
         */
        if ($url === null) {
            $url = $this->request->fullUrl();
        }

        /**
         * If the URL is a closure then call it.
         */
        if ($url instanceof \Closure) {
            $url = app()->call($url, compact('form'));
        }

        $form->setResponse(redirect($url));
    }
}
