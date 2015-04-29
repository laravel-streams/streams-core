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
     * The form fields.
     *
     * @var string
     */
    protected $fields = 'Anomaly\Streams\Platform\Assignment\Form\AssignmentFormFields@handle';

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


    /**
     * Get the related field ID.
     *
     * @return int|null
     */
    public function getFieldId()
    {
        $assignment = $this->getFormEntry();

        if (!$assignment) {
            return null;
        }

        return $assignment->getFieldId();
    }
}
