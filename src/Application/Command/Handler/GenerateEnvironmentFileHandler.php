<?php namespace Anomaly\Streams\Platform\Application\Command\Handler;

use Anomaly\Streams\Platform\Application\Command\GenerateEnvironmentFile;

/**
 * Class GenerateEnvironmentFileHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Application\Command\Handler
 */
class GenerateEnvironmentFileHandler
{

    /**
     * Handle the command.
     *
     * @param GenerateEnvironmentFile $command
     */
    public function handle(GenerateEnvironmentFile $command)
    {
        $contents = '';

        foreach ($command->getVariables() as $key => $value) {
            $contents .= strtoupper($key) . '=' . $value . PHP_EOL;
        }

        file_put_contents(base_path('.env'), $contents);
    }
}