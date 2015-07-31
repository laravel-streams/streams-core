<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Action;

use Anomaly\Streams\Platform\Support\Parser;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Illuminate\Contracts\Support\Arrayable;
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

        if (($url = $action->getRedirect()) === false) {
            return;
        }

        $url = $this->parser->parse($url, compact('entry'));

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
            $url = app()->call($url, compact('builder'));
        }

        $builder->setFormResponse($this->redirector->to($url));
    }
}
