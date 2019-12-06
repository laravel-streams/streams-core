<?php

namespace Anomaly\Streams\Platform\Ui\Form\Component\Action;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class ActionBuilder
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class ActionBuilder
{

    /**
     * Build the actions.
     *
     * @param FormBuilder $builder
     */
    public static function build(FormBuilder $builder)
    {
        $form = $builder->getForm();

        $factory = app(ActionFactory::class);

        ActionInput::read($builder);

        foreach ($builder->getActions() as $action) {
            if (array_get($action, 'enabled', true)) {
                $form->addAction($instance = $factory->make($action));
            }
        }
    }
}
