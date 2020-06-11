<?php

namespace Anomaly\Streams\Platform\Ui\Form\Component\Button\Guesser;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
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
            if (($route = Arr::pull($button, 'route')) && $builder->getFormStream()) {

                $button['attributes']['href'] = $entry->route($route);

                continue;
            }

            switch (Arr::get($button, 'button')) {

                case 'cancel':
                    $button['attributes']['href'] = $section->href();
                    break;

                case 'delete':
                    $button['attributes']['href'] = $section->href('delete/' . $entry->key);
                    break;

                default:

                    // Determine the HREF based on the button type.
                    $type = Arr::get($button, 'segment', Arr::get($button, 'button'));

                    if ($type && !Str::contains($type, '\\') && !class_exists($type)) {
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
