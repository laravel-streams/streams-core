<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter\Contract;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Interface FieldFilterInterface
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Component\Filter\Contract
 */
interface FieldFilterInterface extends FilterInterface
{

    /**
     * Set the field.
     *
     * @param  $field
     * @return mixed
     */
    public function setField($field);

    /**
     * Get the field.
     *
     * @return mixed
     */
    public function getField();

    /**
     * Set the field stream.
     *
     * @param StreamInterface $stream
     * @return mixed
     */
    public function setStream(StreamInterface $stream);

    /**
     * Get the field stream.
     *
     * @return StreamInterface
     */
    public function getStream();
}
