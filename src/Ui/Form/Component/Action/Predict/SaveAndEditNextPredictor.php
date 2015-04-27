<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Action\Predict;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class SaveAndEditNextPredictor
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Action\Predict
 */
class SaveAndEditNextPredictor
{

    /**
     * Predict if the save_and_edit_next action
     * should be included.
     *
     * @param FormBuilder $builder
     */
    public function predict(FormBuilder $builder)
    {
        if (array_filter(explode(',', $builder->getRequestValue('edit_next')))) {
            $builder->setActions(array_merge(['save_and_edit_next'], $builder->getActions()));
        }
    }
}
