<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Traits\CommandableTrait;

/**
 * Class BuildFormSectionColumnsCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class BuildFormSectionColumnsCommandHandler
{

    use CommandableTrait;

    /**
     * Handle the command.
     *
     * @param BuildFormSectionColumnsCommand $command
     * @return array
     */
    public function handle(BuildFormSectionColumnsCommand $command)
    {
        $form = $command->getForm();

        $entry     = $form->getEntry();
        $evaluator = $form->getEvaluator();

        $columns = [];

        foreach ($command->getColumns() as $column) {

            // Evaluate the entire row.
            // All first level closures on are gone now.
            $column = $evaluator->evaluate($column, compact('form', 'entry'), $entry);

            // Skip if disabled.
            if (array_get($column, 'enabled') === false) {

                continue;
            }

            // Delegate the building of the column fields.
            $command = new BuildFormSectionFieldsCommand($form, $column['fields']);

            $fields = $this->execute($command);

            $columns[] = compact('fields');
        }

        return $columns;
    }
}
 