<?php

namespace Anomaly\Streams\Platform\Database\Migration\Command\Handler;

use Anomaly\Streams\Platform\Database\Migration\Command\TransformMigrationNameToClass;

/**
 * Class TransformMigrationNameToClassHandler.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Database\Migration\Command\Handler
 */
class TransformMigrationNameToClassHandler
{
    /**
     * Handle the command.
     *
     * @param TransformMigrationNameToClass $command
     * @return string
     */
    public function handle(TransformMigrationNameToClass $command)
    {
        $name = $command->getName();

        $transformed = studly_case(str_replace('.', '_', $name));

        $segments = explode('__', $name);

        // Insert the version number if there are three segments or more
        if (count($segments) >= 3) {
            $key       = $segments[0];
            $version   = $segments[1];
            $migration = $segments[2];

            $transformed =
                studly_case(str_replace('.', '_', $key)).'_'.
                str_replace('.', '_', $version).'_'.
                studly_case(str_replace('.', '_', $migration));
        }

        return $transformed;
    }
}
