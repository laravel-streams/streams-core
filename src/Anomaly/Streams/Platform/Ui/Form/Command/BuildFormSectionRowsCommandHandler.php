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
        $rows = [];

        $form = $command->getForm();

        $entry     = $form->getEntry();
        $evaluator = $form->getEvaluator();

        /**
         * Loop and process rows in this layout container.
         */
        foreach ($command->getRows() as $row) {

            // Evaluate the entire row.
            $row = $evaluator->evaluate($row, compact('form'), $entry);

            // Skip if disabled.
            if (array_get($row, 'enabled') === false) {

                continue;
            }

            // Delegate the building of the columns.
            $columns = $this->execute(new BuildFormSectionColumnsCommand($form, $row['columns']));

            $rows[] = compact('columns');
        }

        return $rows;
    }
}
 