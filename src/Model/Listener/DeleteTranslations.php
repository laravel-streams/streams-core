<?php namespace Anomaly\Streams\Platform\Model\Listener;

use Anomaly\Streams\Platform\Model\Event\ModelWasDeleted;

/**
 * Class DeleteTranslations
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Model\Listener
 */
class DeleteTranslations
{

    /**
     * Handle the event.
     *
     * @param ModelWasDeleted $event
     */
    public function handle(ModelWasDeleted $event)
    {
        $model = $event->getModel();

        if (!$model->isTranslatable()) {
            return;
        }

        foreach ($model->translations as $translation) {
            $translation->delete();
        }
    }
}
