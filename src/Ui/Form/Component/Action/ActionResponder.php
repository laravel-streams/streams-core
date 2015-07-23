<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Action;

use Anomaly\Streams\Platform\Http\Routing\ResponseOverride;
use Anomaly\Streams\Platform\Ui\Form\Component\Action\Contract\ActionHandlerInterface;
use Anomaly\Streams\Platform\Ui\Form\Component\Action\Contract\ActionInterface;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class ActionResponder
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Action
 */
class ActionResponder
{

    /**
     * The response override.
     *
     * @var ResponseOverride
     */
    protected $response;

    /**
     * Create a new ActionResponder instance.
     *
     * @param ResponseOverride $response
     */
    public function __construct(ResponseOverride $response)
    {
        $this->response = $response;
    }

    /**
     * Set the form response using the active action
     * form response handler.
     *
     * @param FormBuilder $builder
     * @param             $action
     */
    public function setFormResponse(FormBuilder $builder, ActionInterface $action)
    {
        $handler = $action->getHandler();

        /**
         * If the handler is a Closure then call
         * it using the application container.
         */
        if ($handler instanceof \Closure) {
            app()->call($handler, compact('builder'));
        }

        /**
         * If the handler is a callable string then
         * call it using the application container.
         */
        if (is_string($handler) && str_contains($handler, '@')) {
            app()->call($handler, compact('builder'));
        }

        /**
         * If the handle is an instance of ActionHandlerInterface
         * simply call the handle method on it.
         */
        if ($handler instanceof ActionHandlerInterface) {
            $handler->handle($builder);
        }

        /**
         * Set the response override so that
         * the form plugin can play too.
         *
         * If the form is an ajax request then
         * DO NOT override. Ajax is looking for JSON.
         */
        if (!$builder->isAjax()) {
            $this->response->set($builder->getFormResponse());
        }
    }
}
