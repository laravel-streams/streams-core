<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Action;

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
     * Set the form response using the active action
     * form response handler.
     *
     * @param FormBuilder $builder
     * @param             $action
     * @throws \Exception
     */
    public function setFormResponse(FormBuilder $builder, ActionInterface $action)
    {
        $handler = $action->getHandler();

        /**
         * If the handler is a Closure then call
         * it using the application container.
         */
        if ($handler instanceof \Closure) {
            return app()->call($handler, compact('builder'));
        }

        /**
         * If the handler is a callable string then
         * call it using the application container.
         */
        if (is_string($handler) && str_contains($handler, '@')) {
            return app()->call($handler, compact('builder'));
        }

        /**
         * If the handle is an instance of ActionHandlerInterface
         * simply call the handle method on it.
         */
        if ($handler instanceof ActionHandlerInterface) {
            return $handler->handle($builder);
        }

        throw new \Exception('Action $handler must be a callable string, Closure or ActionHandlerInterface.');
    }
}
