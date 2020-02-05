<?php

namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\Component\Action\ActionBuilder;
use Anomaly\Streams\Platform\Ui\Form\Component\Action\Command\SetActiveAction;
use Anomaly\Streams\Platform\Ui\Form\Component\Button\ButtonBuilder;
use Anomaly\Streams\Platform\Ui\Form\Component\Field\FieldBuilder;
use Anomaly\Streams\Platform\Ui\Form\Component\Section\SectionBuilder;
use Anomaly\Streams\Platform\Ui\Form\Event\FormWasBuilt;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

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

        /*
         * Setup some objects and options using
         * provided input or sensible defaults.
         */
        dispatch_now(new AddAssets($this->builder));
        dispatch_now(new SetFormModel($this->builder));
        dispatch_now(new SetFormStream($this->builder));
        dispatch_now(new SetRepository($this->builder));
        dispatch_now(new SetFormEntry($this->builder));
        dispatch_now(new SetFormVersion($this->builder));
        dispatch_now(new SetDefaultParameters($this->builder));
        dispatch_now(new SetFormOptions($this->builder));
        dispatch_now(new SetDefaultOptions($this->builder));

        /*
         * Load anything we need that might be flashed.
         */
        dispatch_now(new LoadFormErrors($this->builder));

        /*
         * Before we go any further, authorize the request.
         */
        dispatch_now(new AuthorizeForm($this->builder));

        /*
         * Build form fields.
         */
        FieldBuilder::build($this->builder);

        /*
         * Build form sections.
         */
        SectionBuilder::build($this->builder);

        /*
         * Build form actions and flag active.
         */
        ActionBuilder::build($this->builder);

        dispatch_now(new SetActiveAction($this->builder));

        /*
         * Build form buttons.
         */
        ButtonBuilder::build($this->builder);

        event(new FormWasBuilt($this->builder));
    }
}
