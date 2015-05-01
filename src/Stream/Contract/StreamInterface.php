<?php namespace Anomaly\Streams\Platform\Stream\Contract;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Assignment\AssignmentCollection;
use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Entry\EntryModel;
use Anomaly\Streams\Platform\Field\Contract\FieldInterface;

/**
 * Interface StreamInterface
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Stream\Contract
 */
interface StreamInterface
{

    /**
     * Compile the entry models.
     *
     * @return mixed
     */
    public function compile();

    /**
     * Get the ID.
     *
     * @return null|int
     */
    public function getId();

    /**
     * Get the namespace.
     *
     * @return string
     */
    public function getNamespace();

    /**
     * Get the slug.
     *
     * @return string
     */
    public function getSlug();

    /**
     * Get the prefix.
     *
     * @return string
     */
    public function getPrefix();

    /**
     * Get the name.
     *
     * @return string
     */
    public function getName();

    /**
     * Get the description.
     *
     * @return string
     */
    public function getDescription();

    /**
     * Get the translatable flag.
     *
     * @return bool
     */
    public function isTranslatable();

    /**
     * Get the trashable flag.
     *
     * @return bool
     */
    public function isTrashable();

    /**
     * Get the title column.
     *
     * @return string
     */
    public function getTitleColumn();

    /**
     * Get the title field.
     *
     * @return null|FieldInterface
     */
    public function getTitleField();

    /**
     * Get the related assignments.
     *
     * @return AssignmentCollection
     */
    public function getAssignments();

    /**
     * Get the related date assignments.
     *
     * @return AssignmentCollection
     */
    public function getDateAssignments();

    /**
     * Get the related translatable assignments.
     *
     * @return AssignmentCollection
     */
    public function getTranslatableAssignments();

    /**
     * Get the related relationship assignments.
     *
     * @return AssignmentCollection
     */
    public function getRelationshipAssignments();

    /**
     * Get an assignment by it's field's slug.
     *
     * @param  $fieldSlug
     * @return AssignmentInterface
     */
    public function getAssignment($fieldSlug);

    /**
     * Get a stream field by it's slug.
     *
     * @param  $slug
     * @return FieldInterface
     */
    public function getField($slug);

    /**
     * Get the entry model.
     *
     * @return EntryModel
     */
    public function getEntryModel();

    /**
     * Get the entry model name.
     *
     * @return string
     */
    public function getEntryModelName();

    /**
     * Get a field's type by the field's slug.
     *
     * @param                $fieldSlug
     * @param EntryInterface $entry
     * @param null|string    $locale
     * @return FieldType
     */
    public function getFieldType($fieldSlug, EntryInterface $entry = null, $locale = null);

    /**
     * Get the entry table name.
     *
     * @return string
     */
    public function getEntryTableName();

    /**
     * Get the entry translations table name.
     *
     * @return string
     */
    public function getEntryTranslationsTableName();

    /**
     * Get the foreign key.
     *
     * @return string
     */
    public function getForeignKey();

    /**
     * Flush the entry stream's cache.
     *
     * @return StreamInterface
     */
    public function flushCache();

    /**
     * @return array
     */
    public function toArray();
}
