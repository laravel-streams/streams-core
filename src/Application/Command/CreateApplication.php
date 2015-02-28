<?php namespace Anomaly\Streams\Platform\Application\Command;

/**
 * Class CreateApplication
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Application\Command
 */
class CreateApplication
{

    /**
     * The application attributes.
     *
     * @var array
     */
    protected $attributes;

    /**
     * Create a new CreateApplication instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Get the attributes.
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }
}
