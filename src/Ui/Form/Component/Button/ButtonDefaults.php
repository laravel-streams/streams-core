<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Button;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class ButtonDefaults
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Button
 */
class ButtonDefaults
{

    /**
     * Default the form buttons when none are defined.
     *
     * @param FormBuilder $builder
     */
    public function defaults(FormBuilder $builder)
    {
        $enabled = $builder->getFormOption('enable_defaults', []);

        if ($enabled === false) {
            return;
        }

        if (is_array($enabled) && !in_array('buttons', $enabled)) {
            return;
        }

        if ($builder->getButtons() === []) {
            $builder->setButtons(['cancel']);
        }
    }
}
