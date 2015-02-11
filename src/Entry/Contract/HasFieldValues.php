<?php namespace Anomaly\Streams\Platform\Entry\Contract;

/**
 * Interface HasFieldValues
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Entry\Contract
 */
interface HasFieldValues
{

    /**
     * Get a field value.
     *
     * @param      $fieldSlug
     * @param bool $decorate
     * @return mixed
     */
    public function getFieldValue($fieldSlug, $decorate = false);

    /**
     * Set a field value.
     *
     * @param $fieldSlug
     * @param $value
     * @return mixed
     */
    public function setFieldValue($fieldSlug, $value);
}
