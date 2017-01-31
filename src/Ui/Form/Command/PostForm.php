<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\Event\FormWasPosted;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Anomaly\Streams\Platform\Ui\Form\Multiple\MultipleFormBuilder;
use Illuminate\Contracts\Events\Dispatcher;
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
     *
     * @param Dispatcher $events
     */
    public function handle(Dispatcher $events)
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
            $this->dispatch(new ValidateForm($this->builder));
        }

        $this->dispatch(new LoadFormValues($this->builder));
        $this->dispatch(new RemoveSkippedFields($this->builder));
        $this->dispatch(new HandleForm($this->builder));
        $this->dispatch(new SetSuccessMessage($this->builder));
        $this->dispatch(new SetActionResponse($this->builder));

        if ($this->builder->isAjax()) {
            $this->dispatch(new SetJsonResponse($this->builder));
        }

        $this->builder->fire('posted', ['builder' => $this->builder]);
        $this->builder->fireFieldEvents('form_posted');

        $events->fire(new FormWasPosted($this->builder));
    }
}
