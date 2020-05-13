<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Button\Guesser;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class PolicyGuesser
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class PolicyGuesser
{

    /**
     * Guess the text for a button.
     *
     * @param TableBuilder $builder
     */
    public static function guess(TableBuilder $builder)
    {
        $buttons = $builder->getButtons();

        if (!$module = app('module.collection')->active()) {
            return;
        }

        if (!$stream = $builder->stream) {
            return;
        }

        foreach ($buttons as &$button) {
            if (isset($button['ability'])) {
                continue;
            }

            /*
             * Try and guess the ability value.
             * @todo mention of abilitys can pry go - use policies and gates.
             */
            switch (array_get($button, 'button')) {

                case 'update':
                    $button['ability'] = $module->getNamespace($stream->slug . '.write');
                    break;

                default:
                    $button['ability'] = $module->getNamespace(
                        $stream->slug . '.' . array_get($button, 'slug')
                    );
                    break;
            }
        }

        $builder->setButtons($buttons);
    }
}
