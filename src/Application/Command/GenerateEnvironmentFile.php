<?php namespace Anomaly\Streams\Platform\Application\Command;


/**
 * Class GenerateEnvironmentFile
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Application\Command
 */
class GenerateEnvironmentFile
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
     * Get the variables.
     *
     * @return array
     */
    public function getVariables()
    {
        return $this->variables;
    }
}
