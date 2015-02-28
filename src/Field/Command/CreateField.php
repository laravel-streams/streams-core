<?php namespace Anomaly\Streams\Platform\Field\Command;

/**
 * Class CreateField
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Field\Command
 */
class CreateField
{

    /**
     * The field attributes.
     *
     * @var array
     */
    protected $attributes;

    /**
     * Create a new CreateField instance.
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
