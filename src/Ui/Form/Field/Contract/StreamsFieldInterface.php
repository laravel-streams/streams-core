<?php namespace Anomaly\Streams\Platform\Ui\Form\Field\Contract;

/**
 * Interface StreamsFieldInterface
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Form\Field\Contract
 */
interface StreamsFieldInterface
{

    /**
     * Return the view data.
     *
     * @param  array $arguments
     * @return mixed
     */
    public function toArray();

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
     * Get the stream object.
     *
     * @return mixed
     */
    public function getStream();

    /**
     * Get the entry object.
     *
     * @return mixed
     */
    public function getEntry();

    /**
     * Get the form object.
     *
     * @return mixed
     */
    public function getForm();
}
