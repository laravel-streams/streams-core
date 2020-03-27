<?php

namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Undocumented class
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SetFormOptions
{

    /**
     * Handle the command.
     * 
     * @param FormBuilder $builder
     */
    public function handle(FormBuilder $builder)
    {
        evaluate(
            resolver($builder->getOptions(), ['builder' => $builder]),
            ['builder' => $builder]
        );

        foreach ($builder->getOptions() as $key => $value) {
            $builder->setFormOption($key, $value);
        }
    }
}
