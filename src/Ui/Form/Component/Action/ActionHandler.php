<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Action;

use Anomaly\Streams\Platform\Support\Parser;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

/**
 * Class ActionHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Action
 */
class ActionHandler implements SelfHandling
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
     * The redirector utility.
     *
     * @var Redirector
     */
    protected $redirector;

    /**
     * Create a new ActionHandler instance.
     *
     * @param Parser     $parser
     * @param Request    $request
     * @param Redirector $redirector
     */
    public function __construct(Parser $parser, Request $request, Redirector $redirector)
    {
        $this->parser     = $parser;
        $this->request    = $request;
        $this->redirector = $redirector;
    }

    /**
     * Handle the form response.
     *
     * @param FormBuilder $builder
     */
    public function handle(FormBuilder $builder)
    {
        /**
         * If the form already has a response
         * then we're being overridden. Abort!
         */
        if ($builder->getFormResponse()) {
            return;
        }

        $entry   = $builder->getFormEntry();
        $actions = $builder->getFormActions();

        $action = $actions->active();

        if ($entry && $entry instanceof Arrayable) {
            $entry = $entry->toArray();
        }

        // Get the redirect from the form first.
        $redirect = $builder->getFormOption('redirect');

        if ($redirect === null) {
            $redirect = $action->getRedirect();
        }

        if ($redirect instanceof RedirectResponse) {

            $builder->setFormResponse($redirect);

            return;
        }

        if ($redirect === false) {
            return;
        }

        $redirect = $this->parser->parse($redirect, compact('entry'));

        /**
         * If the redirect is null then use the current one.
         */
        if ($redirect === null) {
            $redirect = $this->redirector->back()->getTargetUrl();
        }

        /**
         * If the URL is a closure then call it.
         */
        if ($redirect instanceof \Closure) {
            $redirect = app()->call($redirect, compact('builder'));
        }

        $builder->setFormResponse($this->redirector->to($redirect));
    }
}
