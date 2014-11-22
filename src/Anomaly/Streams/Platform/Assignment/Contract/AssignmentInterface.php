<?php namespace Anomaly\Streams\Platform\Assignment\Contract;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Interface AssignmentInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Assignment\Contract
 */
interface AssignmentInterface
{

    /**
     * Get the related stream.
     *
     * @return StreamInterface
     */
    public function getStream();

    /**
     * Get the related field.
     *
     * @return FieldInterface
     */
    public function getField();

    /**
     * Get the label.
     *
     * @return mixed
     */
    public function getLabel();

    /**
     * Get the placeholder.
     *
     * @return mixed
     */
    public function getPlaceholder();

    /**
     * Get the instructions.
     *
     * @return mixed
     */
    public function getInstructions();

    /**
     * Get the unique flag.
     *
     * @return bool
     */
    public function isUnique();

    /**
     * Get the required flag.
     *
     * @return bool
     */
    public function isRequired();

    /**
     * Get the translatable flag.
     *
     * @return bool
     */
    public function isTranslatable();

    /**
     * Get the field slug.
     *
     * @return mixed
     */
    public function getFieldSlug();

    /**
     * Get the assignment's field's type.
     *
     * @param EntryInterface $entry
     * @param null           $locale
     * @return FieldType
     */
    public function getFieldType(EntryInterface $entry = null, $locale = null);
}
