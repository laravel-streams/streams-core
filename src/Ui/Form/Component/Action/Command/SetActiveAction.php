<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Action\Command;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

class SetActiveAction
{

    /**
     * Set the active action.
     * 
     * @param FormBuilder $builder
     */
    public function handle(FormBuilder $builder)
    {
        $options = $builder->getFormOptions();
        $actions = $builder->getFormActions();

        if ($action = $actions->findBySlug(app('request')->get($options->get('prefix') . 'action'))) {
            $action->setActive(true);
        }

        if (!$action && $action = $actions->first()) {
            $action->setActive(true);
        }
    }
}
