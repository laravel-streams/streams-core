<?php

namespace Anomaly\Streams\Platform\Ui\Form\Component\Button;

use Anomaly\Streams\Platform\Ui\Form\Component\Button\Guesser\DisabledGuesser;
use Anomaly\Streams\Platform\Ui\Form\Component\Button\Guesser\EnabledGuesser;
use Anomaly\Streams\Platform\Ui\Form\Component\Button\Guesser\HrefGuesser;
use Anomaly\Streams\Platform\Ui\Form\Component\Button\Guesser\TextGuesser;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class ButtonGuesser
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ButtonGuesser
{

    /**
     * Guess button properties.
     *
     * @param FormBuilder $builder
     */
    public static function guess(FormBuilder $builder)
    {
        HrefGuesser::guess($builder);
        TextGuesser::guess($builder);
        EnabledGuesser::guess($builder);
        DisabledGuesser::guess($builder);
    }
}
