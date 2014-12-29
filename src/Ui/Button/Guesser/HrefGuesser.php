<?php namespace Anomaly\Streams\Platform\Ui\Button\Guesser;

class HrefGuesser
{

    /**
     * Guess the button's HREF attribute.
     *
     * @param array $button
     * @return array
     */
    public function guess(array $button)
    {
        /**
         * If the href is already set then skip it.
         */
        if (isset($button['attributes']['href'])) {
            return $button;
        }

        // We'll use this to determine best URLs.
        $path = app('router')->getCurrentRoute()->getPath();

        /**
         * Guess the URL based on the button parameter.
         */
        switch (array_get($button, 'button')) {

            /**
             * If using the view button then suggest
             * the best practice for the "view" URL.
             */
            case 'view':
                $button['attributes']['href'] = url($path . '/show/{{ entry.id }}');
                break;

            /**
             * If using the edit button then suggest
             * the best practice for the "edit" URL.
             */
            case 'edit':
                $button['attributes']['href'] = url($path . '/edit/{{ entry.id }}');
                break;

            /**
             * If using the edit button then suggest
             * the best practice for the "delete" URL.
             */
            case 'delete':
                $button['attributes']['href'] = url($path . '/delete/{{ entry.id }}');
                break;

            // No guess
            default:
                break;
        }

        return $button;
    }
}
