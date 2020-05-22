<?php

namespace Anomaly\Streams\Platform\Ui\Form\Component\Button\Guesser;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Illuminate\Http\Request;

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
     * Guess the HREF for a button.
     *
     * @param FormBuilder $builder
     */
    public static function guess(FormBuilder $builder)
    {
        $buttons = $builder->buttons;
        $mode    = $builder->mode;

        foreach ($buttons as &$button) {

            if (!isset($button['enabled'])) {
                continue;
            }

            if (is_bool($button['enabled'])) {
                continue;
            }

            $button['enabled'] = ($mode === $button['enabled']);
        }

        $builder->buttons = $buttons;
    }
}
