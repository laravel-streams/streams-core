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
        $columns = [];

        $form = $command->getForm();

        /**
         * Loop and process column configurations.
         */
        foreach ($command->getColumns() as $column) {

            // Skip if disabled.
            if (array_get($column, 'enabled') === false) {

                continue;
            }

            // Delegate the building of the column fields.
            $fields = $this->execute(new BuildFormSectionFieldsCommand($form, $column['fields']));

            $columns[] = compact('fields');
        }

        return $columns;
    }
}
 