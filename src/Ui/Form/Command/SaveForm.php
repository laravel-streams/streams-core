<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\Event\FormWasSaved;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
;
use Illuminate\Contracts\Events\Dispatcher;

/**
 * Class SaveForm
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class SaveForm
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
        // We can't save if there is no repository.
        if (!$repository = $this->builder->getRepository()) {
            return;
        }

        $this->builder->fire('saving', ['builder' => $this->builder]);
        $this->builder->fireFieldEvents('form_saving');

        $repository->save($this->builder);

        $this->builder->fire('saved', ['builder' => $this->builder]);
        $this->builder->fireFieldEvents('form_saved');

        $events->fire(new FormWasSaved($this->builder));
    }
}
