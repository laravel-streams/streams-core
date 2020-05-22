<?php

namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Workflow\Workflow;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Anomaly\Streams\Platform\Ui\Form\Event\FormWasBuilt;
use Anomaly\Streams\Platform\Ui\Form\Component\Field\FieldBuilder;
use Anomaly\Streams\Platform\Ui\Form\Component\Action\ActionBuilder;
use Anomaly\Streams\Platform\Ui\Form\Component\Button\ButtonBuilder;
use Anomaly\Streams\Platform\Ui\Form\Component\Section\SectionBuilder;
use Anomaly\Streams\Platform\Ui\Form\Component\Action\Command\SetActiveAction;

/**
 * Class BuildForm
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class BuildForm
{

    /**
     * The form builder.
     *
     * @var FormBuilder
     */
    protected $builder;

    /**
     * Create a new BuildFormColumnsCommand instance.
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
        $workflow = new Workflow([

            /*
            * Setup some objects and options using
            * provided input or sensible defaults.
            */
            // AddAssets::class,
            // SetFormModel::class,
            // SetFormStream::class,
            // SetRepository::class,
            // SetFormEntry::class,
            // SetDefaultParameters::class,
            // SetFormOptions::class,
            // SetDefaultOptions::class,

            /*
            * Load anything we need that might be flashed.
            */
            LoadFormErrors::class,

            /*
            * Before we go any further, authorize the request.
            */
            AuthorizeForm::class,

            /*
            * Build form fields.
            */
            'field_builder' => function() {
                FieldBuilder::build($this->builder);
            },

            /*
            * Build form sections.
            */
            'section_builder' => function() {
                SectionBuilder::build($this->builder);
            },

            /*
            * Build form actions and flag active.
            */
            'action_builder' => function() {
                ActionBuilder::build($this->builder);
            },

            SetActiveAction::class,

            /*
            * Build form buttons.
            */
            'button_builder' => function() {
                ButtonBuilder::build($this->builder);
            }
        ]);

        /**
         * Process the workflow.
         */
        $workflow->process(['builder' => $this->builder]);

        event(new FormWasBuilt($this->builder));
    }
}
