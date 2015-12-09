<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
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
     *
     * @param ModuleCollection $modules
     */
    public function handle(ModuleCollection $modules)
    {
        $form = $this->builder->getForm();

        /**
         * Set the default panel classes.
         */
        if ($form->getOption('panel_class') === null) {
            $form->setOption('panel_class', 'panel');
        }

        if ($form->getOption('panel_title_class') === null) {
            $form->setOption('panel_title_class', 'title');
        }

        if ($form->getOption('panel_heading_class') === null) {
            $form->setOption('panel_heading_class', $form->getOption('panel_class') . '-heading');
        }

        if ($form->getOption('panel_body_class') === null) {
            $form->setOption('panel_body_class', $form->getOption('panel_class') . '-body');
        }

        if ($form->getOption('container_class') === null) {
            $form->setOption('container_class', 'container-fluid');
        }

        /**
         * If the permission is not set then
         * try and automate it.
         */
        if ($form->getOption('permission') === null && ($module = $modules->active(
            )) && ($stream = $this->builder->getFormStream())
        ) {
            $form->setOption(
                'permission',
                [
                    $module->getNamespace($stream->getSlug() . '.write'),
                    $module->getNamespace($stream->getSlug() . '.' . $this->builder->getFormMode())
                ]
            );
        }
    }
}
