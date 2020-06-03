<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Button\Workflows\Buttons;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Ui\Support\Normalizer;

/**
 * Class NormalizeButtons
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class NormalizeButtons
{

    /**
     * Handle the step.
     *
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {
        $buttons = $builder->buttons;

        foreach ($buttons as $slug => &$button) {

            /*
             * If the slug is numeric and the button is
             * a string then treat the string as both the
             * button and the slug. This is OK as long as
             * there are not multiple instances of this
             * input using the same button which is not likely.
             */
            if (is_numeric($slug) && is_string($button)) {
                $button = [
                    'slug' => $button,
                    'button' => $button,
                ];
            }

            /*
             * If the slug is NOT numeric and the button is a
             * string then use the slug as the slug and the
             * button as the button.
             */
            if (!is_numeric($slug) && is_string($button)) {
                $button = [
                    'slug' => $slug,
                    'button' => $button,
                ];
            }

            /*
             * If the slug is not numeric and the button is an
             * array without a slug then use the slug for
             * the slug for the button.
             */
            if (is_array($button) && !isset($button['slug']) && !is_numeric($slug)) {
                $button['slug'] = $slug;
            }

            /*
             * Make sure we have a button property.
             */
            if (is_array($button) && !isset($button['button'])) {
                $button['button'] = $button['slug'];
            }
        }

        $buttons = Normalizer::attributes($buttons);

        /**
         * Go back over and assume HREFs.
         * @todo rebutton this - from guesser
         */
        foreach ($buttons as $slug => &$button) {
            //
        }

        $builder->buttons = $buttons;
    }
}
