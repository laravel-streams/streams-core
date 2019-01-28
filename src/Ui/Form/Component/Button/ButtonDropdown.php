<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Button;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class ButtonDropdown
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ButtonDropdown
{

    /**
     * Flatten the dropdowns
     *
     * @param FormBuilder $builder
     */
    public function flatten(FormBuilder $builder)
    {
        $buttons = $builder->getButtons();

        foreach ($buttons as $key => &$button) {
            if (isset($button['dropdown'])) {
                foreach (array_pull($button, 'dropdown') as $dropdown) {
                    $dropdown['parent'] = $button['button'];

                    $buttons[] = $dropdown;
                }
            }
        }

        $builder->setButtons($buttons);
    }

    /**
     * Build dropdown items.
     *
     * @param FormBuilder $builder
     */
    public function build(FormBuilder $builder)
    {
        $buttons = $builder->getButtons();

        foreach ($buttons as $key => &$button) {
            if ($dropdown = array_value($button, 'parent')) {
                foreach ($buttons as &$parent) {
                    if (array_value($parent, 'button') == $dropdown) {
                        if (!isset($parent['dropdown'])) {
                            $parent['dropdown'] = [];
                        }

                        $parent['dropdown'][] = $button;
                    }
                }
            }
        }

        $builder->setButtons($buttons);
    }
}
