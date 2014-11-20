<?php namespace Anomaly\Streams\Platform\Assignment\Contract;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;

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
     * @return mixed
     */
    public function getStream();

    /**
     * Get the related field.
     *
     * @return mixed
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
     * @return mixed
     */
    public function isUnique();

    /**
     * Get the required flag.
     *
     * @return mixed
     */
    public function isRequired();

    /**
     * Get the translatable flag.
     *
     * @return mixed
     */
    public function isTranslatable();

    /**
     * Get the assignment's field's type.
     *
     * @param EntryInterface $entry
     * @param null           $locale
     * @return mixed
     */
    public function getFieldType(EntryInterface $entry = null, $locale = null);

    /**
     * Get the field slug.
     *
     * @return mixed
     */
    public function getFieldSlug();
}
