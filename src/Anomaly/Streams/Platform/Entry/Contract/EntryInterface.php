<?php namespace Anomaly\Streams\Platform\Entry\Contract;

use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Interface EntryInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Entry\Contract
 */
interface EntryInterface
{

    /**
     * Touch meta timestamps and user fields.
     *
     * @return EntryInterface
     */
    public function touchMeta();

    /**
     * Get the stream.
     *
     * @return StreamInterface
     */
    public function getStream();

    /**
     * Get a field by it's slug.
     *
     * @param $slug
     * @return FieldInterface
     */
    public function getField($slug);

    /**
     * Get an assignment by field slug.
     *
     * @param $fieldSlug
     * @return AssignmentInterface
     */
    public function getAssignment($fieldSlug);

    /**
     * Get an attribute value by a field slug.
     *
     * @param      $fieldSlug
     * @param null $locale
     * @param bool $mutate
     * @return mixed
     */
    public function getFieldValue($fieldSlug, $locale = null, $mutate = true);

    /**
     * Get a field's type by the field's slug.
     *
     * @param $fieldSlug
     * @return mixed
     */
    public function getFieldType($fieldSlug);

    /**
     * Get a specified relationship.
     *
     * @param  string $relation
     * @return mixed
     */
    public function getRelation($relation);

    /**
     * Get the translatable flag.
     *
     * @return mixed
     */
    public function isTranslatable();
}
 