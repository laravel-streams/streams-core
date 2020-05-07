<?php

namespace Anomaly\Streams\Platform\Ui\Form\Component\Action;

use Anomaly\Streams\Platform\Ui\Form\Component\Action\Contract\ActionHandlerInterface;
use Anomaly\Streams\Platform\Ui\Form\Component\Action\Action;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Facades\App;

/**
 * Class ActionResponder
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ActionResponder
{

    /**
     * Set the form response using the active action
     * form response handler.
     *
     * @param FormBuilder $builder
     * @param             $action
     */
    public function setFormResponse(FormBuilder $builder, Action $action)
    {
        $handler = $action->handler;

        /*
         * If the handler is a closure or callable
         * string then call it using the service container.
         */
        if (is_string($handler) || $handler instanceof \Closure) {
            App::call($handler, compact('builder'), 'handle');
        }

        /*
         * If the handle is an instance of ActionHandlerInterface
         * simply call the handle method on it.
         */
        if ($handler instanceof ActionHandlerInterface) {
            $handler->handle($builder);
        }
    }
}
