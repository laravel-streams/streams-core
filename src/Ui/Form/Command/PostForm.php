<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\Event\FormWasPosted;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Anomaly\Streams\Platform\Ui\Form\Multiple\MultipleFormBuilder;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class PostForm
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class PostForm
{

    use DispatchesJobs;

    /**
     * The form builder.
     *
     * @var FormBuilder
     */
    protected $builder;

    /**
     * Create a new PostForm instance.
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
        $this->builder->fire('posting', ['builder' => $this->builder]);
        $this->builder->fireFieldEvents('form_posting');

        /**
         * Multiple form builders do not get
         * validated here.. in fact:
         *
         * @todo: Decouple validation into it's own method like multiple form builders
         */
        if (!$this->builder instanceof MultipleFormBuilder) {
            dispatch_sync(new ValidateForm($this->builder));
        }

        dispatch_sync(new LoadFormValues($this->builder));
        dispatch_sync(new RemoveSkippedFields($this->builder));
        dispatch_sync(new HandleForm($this->builder));
        dispatch_sync(new HandleVersioning($this->builder));
        dispatch_sync(new SetSuccessMessage($this->builder));
        dispatch_sync(new SetActionResponse($this->builder));

        if ($this->builder->isAjax()) {
            dispatch_sync(new SetJsonResponse($this->builder));
        }

        $this->builder->fire('posted', ['builder' => $this->builder]);
        $this->builder->fireFieldEvents('form_posted');

        event(new FormWasPosted($this->builder));
    }
}
