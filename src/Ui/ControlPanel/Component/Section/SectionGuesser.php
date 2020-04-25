<?php

namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section;

use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Guesser\DescriptionGuesser;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Guesser\HrefGuesser;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Guesser\PolicyGuesser;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Guesser\TitleGuesser;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;

/**
 * Class SectionGuesser
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SectionGuesser
{

    /**
     * Guess section properties.
     *
     * @param ControlPanelBuilder $builder
     */
    public static function guess(ControlPanelBuilder $builder)
    {
        HrefGuesser::guess($builder);
        TitleGuesser::guess($builder);
        PolicyGuesser::guess($builder);
        DescriptionGuesser::guess($builder);
    }
}
