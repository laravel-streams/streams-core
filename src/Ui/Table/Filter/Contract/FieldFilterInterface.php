<?php namespace Anomaly\Streams\Platform\Ui\Table\Filter\Contract;

/**
 * Interface FieldFilterInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Filter\Contract
 */
interface FieldFilterInterface extends FilterInterface
{

    /**
     * Set the field.
     *
     * @param $field
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
}
