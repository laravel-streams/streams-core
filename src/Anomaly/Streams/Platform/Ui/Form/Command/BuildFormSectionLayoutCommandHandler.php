<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Traits\CommandableTrait;

/**
 * Class BuildFormSectionLayoutCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class BuildFormSectionLayoutCommandHandler
{

    use CommandableTrait;

    /**
     * Handle the command.
     *
     * @param BuildFormSectionLayoutCommand $command
     * @return array
     */
    public function handle(BuildFormSectionLayoutCommand $command)
    {
        $ui      = $command->getUi();
        $section = $command->getSection();

        // Delegate the building of the rows.
        // If we need to build more here later we can.
        $command = new BuildFormSectionRowsCommand($ui, $section['layout']['rows']);

        $rows = $this->execute($command);

        return compact('rows');
    }

}
 