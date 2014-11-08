<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Traits\CommandableTrait;

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
     * Handle the command.
     *
     * @param BuildFormSectionRowsCommand $command
     * @return array
     */
    public function handle(BuildFormSectionRowsCommand $command)
    {
        $form = $command->getForm();

        $entry   = $form->getEntry();
        $utility = $form->getUtility();

        $rows = [];

        foreach ($command->getRows() as $row) {

            // Evaluate the entire row.
            // All first level closures on are gone now.
            $row = $utility->evaluate($row, [$form, $entry], $entry);

            // Skip if disabled.
            if (!evaluate_key($row, 'enabled', true)) {

                continue;
            }

            // Delegate the building of the columns.
            $command = new BuildFormSectionColumnsCommand($form, $row['columns']);

            $columns = $this->execute($command);

            $rows[] = compact('columns');
        }

        return $rows;
    }
}
 