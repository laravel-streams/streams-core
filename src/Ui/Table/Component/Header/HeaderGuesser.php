<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Header;

use Anomaly\Streams\Platform\Ui\Table\Component\Header\Guesser\HeadingsGuesser;
use Anomaly\Streams\Platform\Ui\Table\Component\Header\Guesser\SortableGuesser;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class HeaderGuesser
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class HeaderGuesser
{

    /**
     * Guess header properties.
     *
     * @param TableBuilder $builder
     */
    public static function guess(TableBuilder $builder)
    {
        HeadingsGuesser::guess($builder);
        SortableGuesser::guess($builder);
    }
}
