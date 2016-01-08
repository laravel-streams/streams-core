<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\Event\FormWasPosted;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class PostForm
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class PostForm implements SelfHandling
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

        $this->dispatch(new LoadFormValues($this->builder));
        $this->dispatch(new ValidateForm($this->builder));
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
