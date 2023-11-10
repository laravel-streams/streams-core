<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\Component\Action\Command\BuildActions;
use Anomaly\Streams\Platform\Ui\Form\Component\Action\Command\SetActiveAction;
use Anomaly\Streams\Platform\Ui\Form\Component\Button\Command\BuildButtons;
use Anomaly\Streams\Platform\Ui\Form\Component\Field\Command\BuildFields;
use Anomaly\Streams\Platform\Ui\Form\Component\Section\Command\BuildSections;
use Anomaly\Streams\Platform\Ui\Form\Event\FormWasBuilt;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class BuildForm
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class BuildForm
{

    use DispatchesJobs;

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
        dispatch_sync(new AddAssets($this->builder));
        dispatch_sync(new SetFormModel($this->builder));
        dispatch_sync(new SetFormStream($this->builder));
        dispatch_sync(new SetRepository($this->builder));
        dispatch_sync(new SetFormEntry($this->builder));
        dispatch_sync(new SetFormVersion($this->builder));
        dispatch_sync(new SetDefaultParameters($this->builder));
        dispatch_sync(new SetFormOptions($this->builder));
        dispatch_sync(new SetDefaultOptions($this->builder));

        /*
         * Load anything we need that might be flashed.
         */
        dispatch_sync(new LoadFormErrors($this->builder));

        /*
         * Before we go any further, authorize the request.
         */
        dispatch_sync(new AuthorizeForm($this->builder));

        /*
         * Lock form model.
         */
        dispatch_sync(new LockFormModel($this->builder));

        /*
         * Build form fields.
         */
        dispatch_sync(new BuildFields($this->builder));

        /*
         * Build form sections.
         */
        dispatch_sync(new BuildSections($this->builder));

        /*
         * Build form actions and flag active.
         */
        dispatch_sync(new BuildActions($this->builder));
        dispatch_sync(new SetActiveAction($this->builder));

        /*
         * Build form buttons.
         */
        dispatch_sync(new BuildButtons($this->builder));

        event(new FormWasBuilt($this->builder));
    }
}
