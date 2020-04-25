<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Button;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Ui\Table\Component\Button\Guesser\HrefGuesser;
use Anomaly\Streams\Platform\Ui\Table\Component\Button\Guesser\TextGuesser;
use Anomaly\Streams\Platform\Ui\Table\Component\Button\Guesser\PolicyGuesser;
use Anomaly\Streams\Platform\Ui\Table\Component\Button\Guesser\EnabledGuesser;

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
     * @param TableBuilder $builder
     */
    public static function guess(TableBuilder $builder)
    {
        HrefGuesser::guess($builder);
        TextGuesser::guess($builder);
        PolicyGuesser::guess($builder);
        EnabledGuesser::guess($builder);
    }
}
