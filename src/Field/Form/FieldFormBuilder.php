<?php namespace Anomaly\Streams\Platform\Field\Form;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class FieldFormBuilder
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Field\Form
 */
class FieldFormBuilder extends FormBuilder
{

    /**
     * The related stream.
     *
     * @var null|StreamInterface
     */
    protected $stream = null;

    /**
     * The form buttons.
     *
     * @var array
     */
    protected $actions = [
        'save'              => [
            'enabled' => 'edit'
        ],
        'save_and_continue' => [
            'enabled' => 'create'
        ]
    ];

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
     * Get the stream namespace.
     *
     * @return string
     */
    public function getStreamNamespace()
    {
        return $this->stream->getNamespace();
    }
}
