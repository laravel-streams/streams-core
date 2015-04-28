<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Action;

use Anomaly\Streams\Platform\Support\Parser;
use Anomaly\Streams\Platform\Ui\Form\Form;
use Illuminate\Contracts\Support\Arrayable;
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
     * The parser utility.
     *
     * @var Parser
     */
    protected $parser;

    /**
     * The request object.
     *
     * @var Request
     */
    protected $request;

    /**
     * Create a new ActionHandler instance.
     *
     * @param Request $request
     */
    public function __construct(Request $request, Parser $parser)
    {
        $this->parser  = $parser;
        $this->request = $request;
    }

    /**
     * Handle the form response.
     *
     * @param Form $form
     */
    public function handle(Form $form)
    {
        /**
         * If the form already has a response
         * then we're being overridden. Abort!
         */
        if ($form->getResponse()) {
            return;
        }

        $entry   = $form->getEntry();
        $actions = $form->getActions();

        $action = $actions->active();

        if ($entry && $entry instanceof Arrayable) {
            $entry = $entry->toArray();
        }

        $url = $this->parser->parse($action->getRedirect(), compact('entry'));

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
