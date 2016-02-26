<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\Event\FormWasSaved;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Events\Dispatcher;

/**
 * Class SaveForm
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class SaveForm implements SelfHandling
{

    /**
     * The form builder.
     *
     * @var FormBuilder
     */
    protected $builder;

    /**
     * Create a new SaveForm instance.
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
        $this->builder->fire('saving', ['builder' => $this->builder]);
        $this->builder->fireFieldEvents('form_saving');

        $repository = $this->builder->getRepository();

        $repository->save($this->builder);

        $this->builder->fire('saved', ['builder' => $this->builder]);
        $this->builder->fireFieldEvents('form_saved');

        $events->fire(new FormWasSaved($this->builder));
    }
}
