<?php

namespace Anomaly\Streams\Platform\Ui\Form\Component\Button\Guesser;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Illuminate\Http\Request;

/**
 * Class DisabledGuesser
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class DisabledGuesser
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

            if (!isset($button['disabled'])) {
                continue;
            }

            if (is_bool($button['disabled'])) {
                continue;
            }

            $button['disabled'] = ($mode === $button['disabled']);
        }

        $builder->buttons = $buttons;
    }
}
