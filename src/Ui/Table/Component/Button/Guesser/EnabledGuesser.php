<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Button\Guesser;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

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
     * @param TableBuilder $builder
     */
    public static function guess(TableBuilder $builder)
    {
        $buttons = $builder->getButtons();

        foreach ($buttons as &$button) {
            // @todo revisit
            // if (isset($button['permission']) && !authorize($button['permission'])) {
            //     $button['enabled'] = false;
            // }
        }

        $builder->setButtons($buttons);
    }
}
