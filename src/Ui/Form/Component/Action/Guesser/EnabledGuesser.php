<?php

namespace Anomaly\Streams\Platform\Ui\Form\Component\Action\Guesser;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class EnabledGuesser.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Action\Guesser
 */
class EnabledGuesser
{
    /**
     * Guess the action's enabled parameter.
     *
     * @param FormBuilder $builder
     */
    public function guess(FormBuilder $builder)
    {
        $actions = $builder->getActions();

        $mode = $builder->getFormMode();

        foreach ($actions as &$action) {
            if (isset($action['enabled']) && is_bool($action['enabled'])) {
                return;
            }

            if (isset($action['enabled']) && is_string($action['enabled'])) {
                $action['enabled'] = $mode === $action['enabled'];
            }
        }

        $builder->setActions($actions);
    }
}
