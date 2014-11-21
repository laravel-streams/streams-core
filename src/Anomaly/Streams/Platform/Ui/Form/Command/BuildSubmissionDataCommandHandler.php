<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Traits\CommandableTrait;

/**
 * Class BuildSubmissionDataCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class BuildSubmissionDataCommandHandler
{

    use CommandableTrait;

    /**
     * Handle the command.
     *
     * @param BuildSubmissionDataCommand $command
     */
    public function handle(BuildSubmissionDataCommand $command)
    {
        $this->execute(new BuildSubmissionDataForIncludedFieldsCommand($command->getForm()));
        $this->execute(new BuildSubmissionDataForDefaultLocaleCommand($command->getForm()));
        $this->execute(new BuildSubmissionDataForTranslationsCommand($command->getForm()));
        //print_r($command->getForm()->getData());die;
    }
}
 