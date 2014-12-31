<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Action;

use Anomaly\Streams\Platform\Ui\Form\Component\Action\Contract\ActionResponseInterface;
use Anomaly\Streams\Platform\Ui\Form\Form;

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
     * @param Form $form
     * @param      $handler
     * @throws \Exception
     */
    public function setFormResponse(Form $form, $handler)
    {
        /**
         * If the handler is a callable string or Closure
         * then call it using the IoC container.
         */
        if (is_string($handler) || $handler instanceof \Closure) {
            return app()->call($handler, compact('form'));
        }

        /**
         * If the handle is an instance of ActionResponseInterface
         * simply call the handle method on it.
         */
        if ($handler instanceof ActionResponseInterface) {
            return $handler->handle($form);
        }

        throw new \Exception('Action $formResponseHandler must be a callable string, Closure or ActionResponseInterface.');
    }
}
