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
        $enabled = $builder->getFormOption('enable_defaults', []);

        if ($enabled === false) {
            return;
        }

        if (is_array($enabled) && !in_array('actions', $enabled)) {
            return;
        }

        if ($builder->getActions() === []) {
            $builder->setActions(['save', 'save_and_edit']);
        }
    }
}
