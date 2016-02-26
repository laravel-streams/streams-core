<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\Component\Action\ActionResponder;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class SetActionResponse
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class SetActionResponse implements SelfHandling
{

    /**
     * The form builder.
     *
     * @var FormBuilder
     */
    protected $builder;

    /**
     * Create a new SetActionResponse instance.
     *
     * @param FormBuilder $builder
     */
    public function __construct(FormBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Handle the command.
     *
     * @param ActionResponder $responder
     */
    public function handle(ActionResponder $responder)
    {
        $actions = $this->builder->getFormActions();

        if ($this->builder->getFormResponse()) {
            return;
        }

        if ($this->builder->hasFormErrors()) {
            return;
        }

        if (!$this->builder->canSave()) {
            return;
        }

        if ($action = $actions->active()) {
            $responder->setFormResponse($this->builder, $action);
        }
    }
}
