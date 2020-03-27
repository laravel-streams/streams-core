<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Button\Guesser;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class HrefGuesser
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class HrefGuesser
{

    /**
     * Guess the HREF for a button.
     *
     * @param TableBuilder $builder
     */
    public static function guess(TableBuilder $builder)
    {
        $buttons = $builder->getButtons();

        $stream = $builder->getTableStream();

        foreach ($buttons as &$button) {

            // If we already have an HREF then skip it.
            if (isset($button['attributes']['href'])) {
                continue;
            }

            /**
             * If a route has been defined then
             * move that to an HREF closure.
             */
            if (isset($button['route']) && $builder->getTableStream()) {

                $button['attributes']['href'] = function ($entry) use ($button) {

                    /* @var EntryInterface $entry */
                    return $entry->route($button['route']);
                };

                continue;
            }

            switch (array_get($button, 'button')) {

                case 'restore':

                    $button['attributes']['href'] = url(
                        'entry/handle/restore/' . $stream->location . '/' . $stream->getSlug() . '/{entry.id}'
                    );

                    break;

                default:

                    // Determine the HREF based on the button type.
                    $type = array_get($button, 'segment', array_get($button, 'button'));

                    if ($type && !str_contains($type, '\\') && !class_exists($type)) {
                        $button['attributes']['href'] = request()->url() . '/' . $type . '/{entry.id}';
                    }

                    break;
            }
        }

        $builder->setButtons($buttons);
    }
}
