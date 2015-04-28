<?php namespace Anomaly\Streams\Platform\Assignment\Form;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class AssignmentFormBuilder
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Assignment\Form
 */
class AssignmentFormBuilder extends FormBuilder
{

    /**
     * The related stream.
     *
     * @var null|StreamInterface
     */
    protected $stream = null;

    /**
     * Get the stream.
     *
     * @return StreamInterface|null
     */
    public function getStream()
    {
        return $this->stream;
    }

    /**
     * Set the stream.
     *
     * @param StreamInterface $stream
     * @return $this
     */
    public function setStream(StreamInterface $stream)
    {
        $this->stream = $stream;

        return $this;
    }

    /**
     * Return the stream ID.
     *
     * @return int
     */
    public function getStreamId()
    {
        return $this->stream->getId();
    }
}
