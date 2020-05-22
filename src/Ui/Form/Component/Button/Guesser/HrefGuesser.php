<?php

namespace Anomaly\Streams\Platform\Ui\Form\Component\Button\Guesser;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Anomaly\Streams\Platform\Ui\Form\Multiple\MultipleFormBuilder;

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
     * @param FormBuilder $builder
     */
    public static function guess(FormBuilder $builder)
    {
        $buttons = $builder->buttons;
        $entry   = $builder->form->entry;

        // Nothing to do if empty.
        if (!$section = cp()->sections->active()) {
            return;
        }

        foreach ($buttons as &$button) {

            // Skip if already defined.
            if (isset($button['attributes']['href'])) {
                continue;
            }

            /**
             * If a route has been defined then
             * move that to an HREF closure.
             */
            if (($route = array_pull($button, 'route')) && $builder->getFormStream()) {

                $button['attributes']['href'] = $entry->route($route);

                continue;
            }

            switch (array_get($button, 'button')) {

                case 'cancel':
                    $button['attributes']['href'] = $section->href();
                    break;

                case 'delete':
                    $button['attributes']['href'] = $section->href('delete/' . $entry->key);
                    break;

                default:

                    // Determine the HREF based on the button type.
                    $type = array_get($button, 'segment', array_get($button, 'button'));

                    if ($type && !str_contains($type, '\\') && !class_exists($type)) {
                        if ($builder instanceof MultipleFormBuilder) {
                            $button['attributes']['href'] = $section->href($type . '/{request.route.parameters.id}');
                        } else {
                            $button['attributes']['href'] = $section->href($type . '/{entry.id}');
                        }
                    }
                    break;
            }
        }

        $builder->buttons = $buttons;
    }
}
