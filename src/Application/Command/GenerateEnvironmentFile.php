<?php namespace Anomaly\Streams\Platform\Application\Command;

use Illuminate\Contracts\Bus\SelfHandling;


/**
 * Class GenerateEnvironmentFile
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Application\Command
 */
class GenerateEnvironmentFile implements SelfHandling
{

    /**
     * The environment variables.
     *
     * @var array
     */
    protected $variables;

    /**
     * Create a new GenerateEnvironmentFile instance.
     *
     * @param array $variables
     */
    public function __construct(array $variables)
    {
        $this->variables = $variables;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        $contents = '';

        foreach ($this->variables as $key => $value) {
            $contents .= strtoupper($key) . '=' . $value . PHP_EOL;
        }

        file_put_contents(base_path('.env'), $contents);
    }
}
