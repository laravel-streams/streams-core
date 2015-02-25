<?php namespace Anomaly\Streams\Platform\Addon\FieldType\Command;

/**
 * Class BuildFieldType
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\FieldType\Command
 */
class BuildFieldType
{

    /**
     * The parameters.
     *
     * @var array
     */
    protected $parameters;

    /**
     * Create a new BuildFieldType instance.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * Get the parameters.
     *
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }
}
