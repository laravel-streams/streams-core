<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Button;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class ButtonNormalizer
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Button
 */
class ButtonNormalizer
{

    /**
     * Normalize button input.
     *
     * @param FormBuilder $builder
     */
    public function normalize(FormBuilder $builder)
    {
        $buttons = $builder->getButtons();

        foreach ($buttons as $key => &$button) {

            /**
             * If the button is a string then use
             * it as the button parameter.
             */
            if (is_string($button)) {
                $button = [
                    'button' => $button,
                ];
            }

            /**
             * If the key is a string and the button
             * is an array without a button param then
             * move the key into the button as that param.
             */
            if (!is_integer($key) && !isset($button['button'])) {
                $button['button'] = $key;
            }

            /**
             * Make sure some default parameters exist.
             */
            $button['attributes'] = array_get($button, 'attributes', []);

            /**
             * Move the HREF if any to the attributes.
             */
            if (isset($button['href'])) {
                array_set($button['attributes'], 'href', array_pull($button, 'href'));
            }

            /**
             * Move the target if any to the attributes.
             */
            if (isset($button['target'])) {
                array_set($button['attributes'], 'target', array_pull($button, 'target'));
            }

            /**
             * Move all data-* keys
             * to attributes.
             */
            foreach ($button as $attribute => $value) {
                if (str_is('data-*', $attribute)) {
                    array_set($button, 'attributes.' . $attribute, array_pull($button, $attribute));
                }
            }

            /**
             * Make sure the HREF is absolute.
             */
            if (
                isset($button['attributes']['href']) &&
                is_string($button['attributes']['href']) &&
                !starts_with($button['attributes']['href'], 'http')
            ) {
                $button['attributes']['href'] = url($button['attributes']['href']);
            }

            /**
             * Normalize dropdown input.
             */
            foreach (array_get($button, 'dropdown', []) as $dropdownKey => &$dropdown) {

                /**
                 * If the dropdown is a string then
                 * use them for the HREF and text.
                 */
                if (is_string($dropdown)) {
                    $dropdown = [
                        'text' => $dropdown,
                        'href' => $dropdownKey
                    ];
                }

                /**
                 * Move the HREF if any to the attributes.
                 */
                if (isset($dropdown['href'])) {
                    array_set($dropdown['attributes'], 'href', array_pull($dropdown, 'href'));
                }

                /**
                 * Move the target if any to the attributes.
                 */
                if (isset($dropdown['target'])) {
                    array_set($dropdown['attributes'], 'target', array_pull($dropdown, 'target'));
                }

                /**
                 * Move all data-* keys to attributes.
                 */
                foreach (array_get($dropdown, 'attributes', []) as $attribute => $value) {
                    if (str_is('data-*', $attribute)) {
                        array_set($dropdown, 'attributes.' . $attribute, array_pull($dropdown, $attribute));
                    }
                }

                /**
                 * Make sure the HREF is absolute.
                 */
                if (
                    isset($dropdown['attributes']['href']) &&
                    is_string($dropdown['attributes']['href']) &&
                    !starts_with($dropdown['attributes']['href'], 'http')
                ) {
                    $dropdown['attributes']['href'] = url($dropdown['attributes']['href']);
                }

                $button['dropdown'] = $dropdown;
            }
        }

        $builder->setButtons($buttons);
    }
}
