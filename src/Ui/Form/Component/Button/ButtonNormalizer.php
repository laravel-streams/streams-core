<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Button;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class ButtonNormalizer
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
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
            $button = $this->process($key, $button);
        }

        $builder->setButtons($buttons);
    }

    /**
     * Process a button.
     *
     * @param $key
     * @param $button
     * @return array|string
     */
    protected function process($key, $button)
    {
        /*
         * If the button is a string then use it as the button parameter.
         */
        if (is_string($button)) {
            $button = [
                'button' => $button,
            ];
        }

        /*
         * If the key is a string and the button is an array without
         * a button param then move the key into the button as that param.
         */
        if (!is_integer($key) && is_array($button) && !array_get($button, 'button')) {
            array_set($button, 'button', $key);
        }

        /*
         * Default to size "sm"
         */
        if (!array_get($button, 'size')) {
            array_set($button, 'size', 'sm');
        }

        /*
         * Make sure some default parameters exist.
         */
        array_set($button, 'attributes', array_get($button, 'attributes', []));

        /*
         * Move the HREF if any to the attributes.
         */
        if (array_get($button, 'href')) {
            array_set($button, 'attributes.href', array_pull($button, 'href'));
        }

        /*
         * Move the target if any to the attributes.
         */
        if (array_get($button, 'target')) {
            array_set($button, 'attributes.target', array_pull($button, 'target'));
        }

        /*
         * Move all data-* keys to attributes.
         */
        foreach ($button as $attribute => $value) {
            if (str_is('data-*', $attribute)) {
                array_set(
                    $button,
                    "attributes.{$attribute}",
                    array_pull($button, $attribute)
                );
            }
        }

        /*
         * Make sure the HREF is absolute.
         */
        $href = array_get($button, 'attributes.href');

        if ($href && is_string($href) && !starts_with($href, ['http', '{'])) {
            array_set($button, 'attributes.href', url($href));
        }

        /*
         * Process nested dropdowns
         */
        if ($nested = array_get($button, 'dropdown')) {
            array_set(
                $button,
                'dropdown',
                array_map(
                    function ($dropdown, $key) {
                        return $this->process($key, $dropdown);
                    }
                    $nested
                )
            );
        }

        return $button;
    }

}
