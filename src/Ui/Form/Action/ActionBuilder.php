<?php namespace Anomaly\Streams\Platform\Ui\Form\Action;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class ActionBuilder
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Action
 */
class ActionBuilder
{

    /**
     * The action interpreter.
     *
     * @var ActionInterpreter
     */
    protected $interpreter;

    /**
     * The action factory.
     *
     * @var ActionFactory
     */
    protected $factory;

    /**
     * Create a new ActionBuilder instance.
     *
     * @param ActionFactory     $factory
     * @param ActionInterpreter $interpreter
     */
    public function __construct(ActionFactory $factory, ActionInterpreter $interpreter)
    {
        $this->factory     = $factory;
        $this->interpreter = $interpreter;
    }

    /**
     * Build the action objects.
     *
     * @param FormBuilder $builder
     */
    public function build(FormBuilder $builder)
    {
        $form    = $builder->getForm();
        $actions = $form->getActions();

        foreach ($builder->getActions() as $key => $parameters) {

            $parameters = $this->interpreter->standardize($key, $parameters);

            $action = $this->factory->make($parameters);

            $action->setPrefix($form->getPrefix());
            $action->setActive(app('request')->has($form->getPrefix() . 'action'));

            $actions->put($action->getSlug(), $action);
        }
    }
}
