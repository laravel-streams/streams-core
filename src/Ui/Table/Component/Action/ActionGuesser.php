<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Action;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\Guesser\TextGuesser;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\Guesser\PolicyGuesser;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\Guesser\HandlerGuesser;

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
     * Guess action parameters.
     *
     * @param TableBuilder $builder
     */
    public static function guess(TableBuilder $builder)
    {
        TextGuesser::guess($builder);
        PolicyGuesser::guess($builder);
        HandlerGuesser::guess($builder);
    }
}
