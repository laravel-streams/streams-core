<?php

namespace Anomaly\Streams\Platform\Field\Command;

use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Class AutoAssignField.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Field\Command
 */
class AssignField
{
    /**
     * The field we're assigning.
     *
     * @var FieldInterface
     */
    protected $field;

    /**
     * The stream to assign to.
     *
     * @var StreamInterface
     */
    protected $stream;

    /**
     * The assignment attributes.
     *
     * @var array
     */
    protected $attributes;

    /**
     * Create a new AutoAssignField instance.
     *
     * @param FieldInterface  $field
     * @param StreamInterface $stream
     * @param array           $attributes
     */
    public function __construct(FieldInterface $field, StreamInterface $stream, array $attributes)
    {
        $this->field      = $field;
        $this->stream     = $stream;
        $this->attributes = $attributes;
    }

    /**
     * The assignment attributes.
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Get the stream.
     *
     * @return StreamInterface
     */
    public function getStream()
    {
        return $this->stream;
    }

    /**
     * Get the field.
     *
     * @return FieldInterface
     */
    public function getField()
    {
        return $this->field;
    }
}
