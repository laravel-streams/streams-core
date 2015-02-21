<?php namespace Anomaly\Streams\Platform\Application\Command;


class GenerateEnvironmentFile
{
    /**
     * @var array
     */
    protected $variables;

    /**
     * @param array $variables
     */
    public function __construct(array $variables)
    {
        $this->variables = $variables;
    }

    /**
     * @return array
     */
    public function getVariables()
    {
        return $this->variables;
    }


}