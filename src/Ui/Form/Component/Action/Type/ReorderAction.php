<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Action\Type;

use Anomaly\Streams\Platform\Ui\Form\Component\Action\Action;
use Anomaly\Streams\Platform\Ui\Form\Contract\FormModelInterface;
use Anomaly\Streams\Platform\Ui\Form\Event\FormPostEvent;

/**
 * Class ReorderAction
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Action\Type
 */
class ReorderAction extends Action
{

    /**
     * Handle the FormPostEvent.
     *
     * @param FormPostEvent $event
     */
    protected function handleFormPostEvent(FormPostEvent $event)
    {
        $form  = $event->getForm();
        $model = $form->getModel();

        if ($model instanceof FormModelInterface) {
            $model->sortFormEntries($form);
        }

        $form->setResponse(redirect(app('request')->fullUrl()));
    }
}
