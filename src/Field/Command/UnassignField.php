<?php namespace Anomaly\Streams\Platform\Field\Command;

use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Class UnassignField
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Field\Command
 */
class UnassignField
{

    /**
     * The field to unassign.
     *
     * @var FieldInterface
     */
    protected $field;

    /**
     * The stream to unassign
     * the field from.
     *
     * @var StreamInterface
     */
    protected $stream;

    /**
     * Create a new UnassignField instance.
     *
     * @param FieldInterface  $field
     * @param StreamInterface $stream
     */
    function __construct(FieldInterface $field, StreamInterface $stream)
    {
        $this->field  = $field;
        $this->stream = $stream;
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

    /**
     * Get the stream.
     *
     * @return StreamInterface
     */
    public function getStream()
    {
        return $this->stream;
    }
}
