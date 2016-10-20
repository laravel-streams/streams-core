<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Action\Guesser;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class EnabledGuesser
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
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
            if (!isset($action['enabled'])) {
                continue;
            }

            if (is_bool($action['enabled'])) {
                continue;
            }

            $action['enabled'] = ($mode === $action['enabled']);
        }

        $builder->setActions($actions);
    }
}
