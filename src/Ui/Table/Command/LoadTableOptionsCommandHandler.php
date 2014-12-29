<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

/**
 * Class LoadTableOptionsCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class LoadTableOptionsCommandHandler
{

    /**
     * Handle the command.
     *
     * @param LoadTableOptionsCommand $command
     */
    public function handle(LoadTableOptionsCommand $command)
    {
        $table = $command->getTable();

        $options = $table->getOptions();
        $data    = $table->getData();

        $data->put('options', $options);
    }
}
