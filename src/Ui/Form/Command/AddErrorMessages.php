<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Message\MessageManger;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class AddErrorMessages
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AddErrorMessages
{

    /**
     * The form builder.
     *
     * @var FormBuilder
     */
    protected $builder;

    /**
     * Create a new AddErrorMessages instance.
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
     * @param MessageManger $messages
     */
    public function handle(MessageManger $messages)
    {
        $form = $this->builder->getForm();

        $errors = $form->getErrors();

        if ($errors instanceof \Illuminate\Support\MessageManger) {
            $messages->error($errors->all());
        }
    }
}
