<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Action;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class ActionDefaults
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Action
 */
class ActionDefaults
{

    /**
     * Default the form actions when none are defined.
     *
     * @param FormBuilder $builder
     */
    public function defaults(FormBuilder $builder)
    {
        if ($builder->getActions() === []) {
            if ($builder->getFormMode() == 'create') {
                $builder->setActions(
                    [
                        'save',
                        'save_edit'
                    ]
                );
            } else {
                $builder->setActions(
                    [
                        'update',
                        'save_exit'
                    ]
                );
            }
        }
    }
}
