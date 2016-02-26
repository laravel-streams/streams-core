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

        foreach (file(base_path('.env'), FILE_IGNORE_NEW_LINES) as $line) {

            // Check for # comments.
            if (starts_with($line, '#')) {
                $data[] = $line;
            } else {

                list($key, $value) = explode('=', $line);

                $data[$key] = $value;
            }
        }

        return $data;
    }
}
