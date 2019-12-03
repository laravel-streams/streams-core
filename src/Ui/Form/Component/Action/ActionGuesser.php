<?php

namespace Anomaly\Streams\Platform\Ui\Form\Component\Action;

use Anomaly\Streams\Platform\Ui\Form\Component\Action\Guesser\DisabledGuesser;
use Anomaly\Streams\Platform\Ui\Form\Component\Action\Guesser\EnabledGuesser;
use Anomaly\Streams\Platform\Ui\Form\Component\Action\Guesser\RedirectGuesser;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class ActionGuesser
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ActionGuesser
{

    /**
     * Guess action properties.
     *
     * @param FormBuilder $builder
     */
    public static function guess(FormBuilder $builder)
    {
        EnabledGuesser::guess($builder);
        DisabledGuesser::guess($builder);
        RedirectGuesser::guess($builder);
    }
}
