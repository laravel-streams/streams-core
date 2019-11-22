<?php

namespace Anomaly\Streams\Platform\Ui\Form\Component\Button;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Anomaly\Streams\Platform\Ui\Support\Normalizer;

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

        Normalizer::component($buttons, 'button');

        Normalizer::attributes($buttons);

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
        if (isset($button['dropdown'])) {
            foreach ($button['dropdown'] as $key => &$dropdown) {
                $dropdown = $this->process($key, $dropdown);
            }
        }

        return $button;
    }
}
