<?php namespace Anomaly\Streams\Platform\Application\Command;

use Illuminate\Contracts\Bus\SelfHandling;


/**
 * Class WriteEnvironmentFile
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Application\Command
 */
class WriteEnvironmentFile implements SelfHandling
{

    /**
     * The environment variables.
     *
     * @var array
     */
    protected $data;

    /**
     * Create a new WriteEnvironmentFile instance.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        $contents = '';

        foreach ($this->data as $key => $value) {
            if ($key) {
                $contents .= strtoupper($key) . '=' . $value . PHP_EOL;
            } else {
                $contents .= $value . PHP_EOL;
            }
        }

        file_put_contents(base_path('.env'), $contents);
    }
}
