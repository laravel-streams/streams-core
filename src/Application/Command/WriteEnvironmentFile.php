<?php namespace Anomaly\Streams\Platform\Application\Command;

/**
 * Class WriteEnvironmentFile
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class WriteEnvironmentFile
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
