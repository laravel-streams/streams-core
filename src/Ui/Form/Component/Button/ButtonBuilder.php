<?php

namespace Anomaly\Streams\Platform\Ui\Form\Component\Button;

use Anomaly\Streams\Platform\Ui\Button\ButtonFactory;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class ButtonBuilder
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class ButtonBuilder
{

    /**
     * Build the buttons.
     *
     * @param FormBuilder $builder
     */
    public static function build(FormBuilder $builder)
    {
        ButtonInput::read($builder);

        $factory = app(ButtonFactory::class);

        foreach ($builder->buttons as $button) {
            if (array_get($button, 'enabled', true)) {

                $builder->form->buttons->add($factory->make($button));
            }
        }
    }
}
