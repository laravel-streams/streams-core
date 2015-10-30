<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class SetDefaultOptions
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Form\Command
 */
class SetDefaultOptions implements SelfHandling
{

    /**
     * The table builder.
     *
     * @var FormBuilder
     */
    protected $builder;

    /**
     * Create a new SetDefaultOptions instance.
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

        /**
         * Set the default panel classes.
         */
        if (!$form->getOption('panel_class')) {
            $form->setOption('panel_class', 'panel');
        }

        if (!$form->getOption('panel_title_class')) {
            $form->setOption('panel_title_class', 'title');
        }

        if (!$form->getOption('panel_heading_class')) {
            $form->setOption('panel_heading_class', $form->getOption('panel_class') . '-heading');
        }

        if (!$form->getOption('panel_body_class')) {
            $form->setOption('panel_body_class', $form->getOption('panel_class') . '-body');
        }

        if (!$form->getOption('container_class')) {
            $form->setOption('container_class', 'container-fluid');
        }
    }
}
