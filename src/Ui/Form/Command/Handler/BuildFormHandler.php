<?php namespace Anomaly\Streams\Platform\Ui\Form\Command\Handler;

use Anomaly\Streams\Platform\Ui\Form\Command\BuildForm;
use Anomaly\Streams\Platform\Ui\Form\Command\SetFormEntry;
use Anomaly\Streams\Platform\Ui\Form\Command\SetFormModel;
use Anomaly\Streams\Platform\Ui\Form\Command\SetFormStream;
use Anomaly\Streams\Platform\Ui\Form\Component\Action\Command\BuildActions;
use Anomaly\Streams\Platform\Ui\Form\Component\Action\Command\SetActiveAction;
use Anomaly\Streams\Platform\Ui\Form\Component\Button\Command\BuildButtons;
use Anomaly\Streams\Platform\Ui\Form\Component\Field\Command\BuildFields;
use Illuminate\Foundation\Bus\DispatchesCommands;

/**
 * Class BuildFormHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class BuildFormHandler
{

    use DispatchesCommands;

    /**
     * Handle the command.
     *
     * @param BuildForm $command
     */
    public function handle(BuildForm $command)
    {
        $builder = $command->getBuilder();

        /**
         * Resolve and set the form model and stream.
         */
        $this->dispatch(new SetFormModel($builder));
        $this->dispatch(new SetFormStream($builder));
        $this->dispatch(new SetFormEntry($builder));

        /*
         * Build form fields.
         */
        $this->dispatch(new BuildFields($builder));

        /**
         * Build form actions and flag active.
         */
        $this->dispatch(new BuildActions($builder));
        $this->dispatch(new SetActiveAction($builder));

        /**
         * Build form buttons.
         */
        $this->dispatch(new BuildButtons($builder));
    }
}
