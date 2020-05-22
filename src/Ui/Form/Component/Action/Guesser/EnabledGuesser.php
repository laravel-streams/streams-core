<?php

namespace Anomaly\Streams\Platform\Ui\Form\Component\Action\Guesser;

use Anomaly\Streams\Platform\Ui\Support\Value;
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
    public static function guess(FormBuilder $builder)
    {
        $actions = $builder->actions;

        $mode = $builder->mode;

        foreach ($actions as &$action) {

            if (!isset($action['enabled'])) {
                continue;
            }

            $action['enabled'] = valuate(
                $action['enabled'],
                $builder->getFormEntry()
            );

            if (is_bool($action['enabled']) || in_array($action['enabled'], ['true', 'false'])) {

                $action['enabled'] = filter_var($action['enabled'], FILTER_VALIDATE_BOOLEAN);

                continue;
            }

            $action['enabled'] = ($mode === $action['enabled']);
        }

        $builder->actions = $actions;
    }
}
