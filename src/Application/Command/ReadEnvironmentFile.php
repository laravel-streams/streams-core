<?php namespace Anomaly\Streams\Platform\Application\Command;

use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class ReadEnvironmentFile
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ReadEnvironmentFile
{

    use DispatchesJobs;

    /**
     * Handle the command.
     *
     * @return array
     */
    public function handle()
    {
        $data = [];

        $file = $this->dispatch(new GetEnvironmentFile());

        if (!file_exists($file)) {
            return $data;
        }

        foreach (file($file, FILE_IGNORE_NEW_LINES) as $line) {

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
