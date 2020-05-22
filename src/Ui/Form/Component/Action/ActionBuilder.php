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
        $factory = app(ActionFactory::class);

        ActionInput::read($builder);

        foreach ($builder->actions as $action) {
            if (array_get($action, 'enabled', true)) {
                $builder->form->actions->add($factory->make($action));
            }
        }
    }
}
