<?php

namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class MakeForm.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class MakeForm implements SelfHandling
{
    /**
     * The form builder.
     *
     * @var FormBuilder
     */
    protected $builder;

    /**
     * Create a new MakeForm instance.
     *
     * @param FormBuilder $builder
     */
    public function __construct(FormBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        $form = $this->builder->getForm();

        $options = $form->getOptions();
        $data    = $form->getData();

        $content = view(
            $options->get('form_view', $this->builder->isAjax() ? 'streams::form/ajax' : 'streams::form/form'),
            $data->all()
        );

        $form->setContent($content);
        $form->addData('content', $content);
    }
}
