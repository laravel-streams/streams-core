<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Button;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class ButtonDefaults
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
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
        if ($builder->getButtons() === []) {
            $builder->setButtons(['cancel']);
        }
    }
}
