<?php

namespace Anomaly\Streams\Platform\Field\Event;

use Anomaly\Streams\Platform\Field\Contract\FieldInterface;

/**
 * Class FieldWasCreated.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Field\Event
 */
class FieldWasCreated
{
    /**
     * The field object.
     *
     * @var FieldInterface
     */
    protected $field;

    /**
     * Create a new FieldWasCreated instance.
     *
     * @param FieldInterface $field
     */
    public function __construct(FieldInterface $field)
    {
        $this->field = $field;
    }

    /**
     * Get the field object.
     *
     * @return FieldInterface
     */
    public function getField()
    {
        return $this->field;
    }
}
