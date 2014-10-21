<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Traits\CommandableTrait;
use Anomaly\Streams\Platform\Ui\Form\Command\BuildFormActionsCommand;
use Anomaly\Streams\Platform\Ui\Form\Command\BuildFormSectionsCommand;
use Anomaly\Streams\Platform\Ui\Form\Contract\FormServiceInterface;

class FormService implements FormServiceInterface
{
    use CommandableTrait;

    protected $ui;

    function __construct(FormUi $ui)
    {
        $this->ui = $ui;
    }

    public function sections()
    {
        $command = new BuildFormSectionsCommand($this->ui);

        return $this->execute($command);
    }

    public function actions()
    {
        $command = new BuildFormActionsCommand($this->ui);

        return $this->execute($command);
    }
}
 