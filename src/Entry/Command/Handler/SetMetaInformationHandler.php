<?php namespace Anomaly\Streams\Platform\Entry\Command\Handler;

use Anomaly\Streams\Platform\Entry\Command\SetMetaInformation;

/**
 * Class SetMetaInformationHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Entry\Command\Handler
 */
class SetMetaInformationHandler
{

    /**
     * Handle the command.
     *
     * @param SetMetaInformation $command
     * @return \Anomaly\Streams\Platform\Entry\EntryModel
     */
    public function handle(SetMetaInformation $command)
    {
        $entry = $command->getEntry();

        $user = app('auth')->id();

        if (!$entry->getKey()) {
            $entry->created_at = time();
            $entry->created_by = $user;
            $entry->updated_at = null;
            $entry->sort_order = $entry->newQuery()->count('id') + 1;
        } else {
            $entry->updated_at = time();
            $entry->updated_by = $user;
        }
    }
}
