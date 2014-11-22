<?php namespace Anomaly\Streams\Platform\Field\Contract;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;

/**
 * Interface FieldInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Field\Contract
 */
interface FieldInterface
{

    /**
     * Get the ID.
     *
     * @return mixed
     */
    public function getId();

    /**
     * Get the name.
     *
     * @return mixed
     */
    public function getName();

    /**
     * Get the field type.
     *
     * @param EntryInterface $entry
     * @param null           $locale
     * @return FieldType
     */
    public function getType(EntryInterface $entry = null, $locale = null);

    /**
     * Get the configuration.
     *
     * @return mixed
     */
    public function getConfig();

    /**
     * Get the validation rules.
     *
     * @return mixed
     */
    public function getRules();

    /**
     * Get the related assignments.
     *
     * @return mixed
     */
    public function getAssignments();

    /**
     * Get the locked flag.
     *
     * @return mixed
     */
    public function isLocked();

    /**
     * Get all attributes.
     *
     * @return mixed
     */
    public function getAttributes();

    /**
     * Get an attribute.
     *
     * @param $key
     * @return mixed
     */
    public function getAttribute($key);
}
 