<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Action\Contract;

use Anomaly\Streams\Platform\Ui\Form\Event\FormPostEvent;

/**
 * Interface ActionHandlerInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Action\Contract
 */
interface ActionHandlerInterface
{

    /**
     * Handle the FormPostEvent.
     *
     * @param FormPostEvent $event
     */
    public function onFormPost(FormPostEvent $event);
}
