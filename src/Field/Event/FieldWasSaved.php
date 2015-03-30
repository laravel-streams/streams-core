<?php namespace Anomaly\Streams\Platform\Field\Event;

use Anomaly\Streams\Platform\Field\Contract\FieldInterface;

/**
 * Class FieldWasSaved
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Field\Event
 */
class FieldWasSaved
{

    /**
     * The field object.
     *
     * @var FieldInterface
     */
    protected $field;

    /**
     * Create a new FieldWasSaved instance.
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
