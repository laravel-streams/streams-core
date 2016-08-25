<?php namespace Anomaly\Streams\Platform\Application\Command;

use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class ReadEnvironmentFile
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Application\Command
 */
class ReadEnvironmentFile implements SelfHandling
{

    /**
     * Handle the command.
     *
     * @return array
     */
    public function handle()
    {
        $data = [];

        if (!file_exists($env = base_path('.env'))) {
            return $data;
        }

        foreach (file($env, FILE_IGNORE_NEW_LINES) as $line) {

            // Check for # comments.
            if (starts_with($line, '#')) {
                $data[] = $line;
            } elseif (strpos($line, '=')) {

                list($key, $value) = explode('=', $line);

                $data[$key] = $value;
            }
        }

        return $data;
    }
}
