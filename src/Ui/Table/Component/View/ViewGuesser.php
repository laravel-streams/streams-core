<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\View;

use Anomaly\Streams\Platform\Ui\Table\Component\View\Guesser\HandlerGuesser;
use Anomaly\Streams\Platform\Ui\Table\Component\View\Guesser\HrefGuesser;
use Anomaly\Streams\Platform\Ui\Table\Component\View\Guesser\QueryGuesser;
use Anomaly\Streams\Platform\Ui\Table\Component\View\Guesser\TextGuesser;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class ViewGuesser
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ViewGuesser
{

    /**
     * Guess some view parameters.
     *
     * @param TableBuilder $builder
     */
    public static function guess(TableBuilder $builder)
    {
        HrefGuesser::guess($builder);
        TextGuesser::guess($builder);
        QueryGuesser::guess($builder);
        HandlerGuesser::guess($builder);
    }
}
