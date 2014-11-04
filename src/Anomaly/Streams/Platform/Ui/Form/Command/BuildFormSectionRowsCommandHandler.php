<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Traits\CommandableTrait;
use Anomaly\Streams\Platform\Ui\Form\FormUtility;

/**
 * Class BuildFormSectionRowsCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class BuildFormSectionRowsCommandHandler
{

    use CommandableTrait;

    /**
     * The form utility object.
     *
     * @var \Anomaly\Streams\Platform\Ui\Form\FormUtility
     */
    protected $utility;

    /**
     * Create a new BuildFormSectionRowsCommandHandler instance.
     *
     * @param FormUtility $utility
     */
    function __construct(FormUtility $utility)
    {
        $this->utility = $utility;
    }

    /**
     * Handle the command.
     *
     * @param BuildFormSectionRowsCommand $command
     * @return array
     */
    public function handle(BuildFormSectionRowsCommand $command)
    {
        $form = $command->getForm();

        $entry = $form->getEntry();

        $rows = [];

        foreach ($command->getRows() as $row) {

            // Evaluate the entire row.
            // All first level closures on are gone now.
            $row = $this->utility->evaluate($row, [$form, $entry], $entry);

            $command = new BuildFormSectionColumnsCommand($form, $row['columns']);

            $columns = $this->execute($command);

            $rows[] = compact('columns');
        }

        return $rows;
    }
}
 