<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Action;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Laracasts\Commander\CommanderTrait;

/**
 * Class ActionBuilder
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Form\Component\Action
 */
class ActionBuilder
{

    use CommanderTrait;

    /**
     * The action reader.
     *
     * @var ActionReader
     */
    protected $reader;

    /**
     * The action factory.
     *
     * @var ActionFactory
     */
    protected $factory;

    /**
     * Create a new ActionBuilder instance.
     *
     * @param ActionReader  $reader
     * @param ActionFactory $factory
     */
    public function __construct(ActionReader $reader, ActionFactory $factory)
    {
        $this->reader  = $reader;
        $this->factory = $factory;
    }

    /**
     * Build the actions.
     *
     * @param FormBuilder $builder
     */
    public function build(FormBuilder $builder)
    {
        $form   = $builder->getForm();
        $actions = $form->getActions();

        foreach ($builder->getActions() as $slug => $action) {

            $action = $this->reader->standardize($slug, $action);
            $action = $this->factory->make($action);

            $actions->put($action->getSlug(), $action);
        }
    }
}
