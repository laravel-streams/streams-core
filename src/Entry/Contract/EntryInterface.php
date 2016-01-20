<?php namespace Anomaly\Streams\Platform\Entry\Contract;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Addon\FieldType\FieldTypePresenter;
use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeQuery;
use Anomaly\Streams\Platform\Assignment\AssignmentCollection;
use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Anomaly\Streams\Platform\Entry\EntryPresenter;
use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
use Anomaly\Streams\Platform\Model\EloquentCollection;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Carbon\Carbon;

/**
 * Interface EntryInterface
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Entry\Contract
 */
interface EntryInterface
{

    /**
     * Get the ID.
     *
     * @return mixed
     */
    public function getId();

    /**
     * Get the entry ID.
     *
     * @return mixed
     */
    public function getEntryId();

    /**
     * Get the entry title.
     *
     * @return mixed
     */
    public function getEntryTitle();

    /**
     * Get the sort order.
     *
     * @return int
     */
    public function getSortOrder();

    /**
     * Get the title.
     *
     * @return mixed
     */
    public function getTitle();

    /**
     * Get the title key.
     *
     * @return string
     */
    public function getTitleName();

    /**
     * Get the stream.
     *
     * @return StreamInterface
     */
    public function getStream();

    /**
     * Get the stream namespace.
     *
     * @return string
     */
    public function getStreamNamespace();

    /**
     * Get the entry's stream slug.
     *
     * @return string
     */
    public function getStreamSlug();

    /**
     * Get the entry's stream name.
     *
     * @return string
     */
    public function getStreamName();

    /**
     * Get the entry's stream prefix.
     *
     * @return string
     */
    public function getStreamPrefix();

    /**
     * Get the table name.
     *
     * @return string
     */
    public function getTableName();

    /**
     * Get related translations.
     *
     * @return EloquentCollection
     */
    public function getTranslations();

    /**
     * Get the translations table name.
     *
     * @return string
     */
    public function getTranslationsTableName();

    /**
     * Get a field by it's slug.
     *
     * @param  $slug
     * @return FieldInterface
     */
    public function getField($slug);

    /**
     * Return whether an entry has
     * a field with a given slug.
     *
     * @param  $slug
     * @return bool
     */
    public function hasField($slug);

    /**
     * Get a field value.
     *
     * @param      $fieldSlug
     * @param null $locale
     * @return mixed
     */
    public function getFieldValue($fieldSlug, $locale = null);

    /**
     * Set a field value.
     *
     * @param $fieldSlug
     * @param $value
     * @return mixed
     */
    public function setFieldValue($fieldSlug, $value);

    /**
     * Get a field's type by the field's slug.
     *
     * @param  $fieldSlug
     * @return FieldType
     */
    public function getFieldType($fieldSlug);

    /**
     * Get the field type query.
     *
     * @param $fieldSlug
     * @return FieldTypeQuery
     */
    public function getFieldTypeQuery($fieldSlug);

    /**
     * Get the field type presenter.
     *
     * @param $fieldSlug
     * @return FieldTypePresenter
     */
    public function getFieldTypePresenter($fieldSlug);

    /**
     * Get all assignments.
     *
     * @return AssignmentCollection
     */
    public function getAssignments();

    /**
     * Get the field slugs for assigned fields.
     *
     * @param null $prefix
     * @return array
     */
    public function getAssignmentFieldSlugs($prefix = null);

    /**
     * Get all assignments of the
     * provided field type namespace.
     *
     * @param $fieldType
     * @return AssignmentCollection
     */
    public function getAssignmentsByFieldType($fieldType);

    /**
     * Get an assignment by field slug.
     *
     * @param  $fieldSlug
     * @return AssignmentInterface
     */
    public function getAssignment($fieldSlug);

    /**
     * Return translated assignments.
     *
     * @return AssignmentCollection
     */
    public function getTranslatableAssignments();

    /**
     * Return relation assignments.
     *
     * @return AssignmentCollection
     */
    public function getRelationshipAssignments();

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
     * @return bool
     */
    public function isTranslatable();

    /**
     * Return whether an entry is deletable or not.
     *
     * @return bool
     */
    public function isDeletable();

    /**
     * Return the last modified datetime.
     *
     * @return Carbon
     */
    public function lastModified();

    /**
     * Return the object's ETag fingerprint.
     *
     * @return string
     */
    public function etag();

    /**
     * Return a new presenter instance.
     *
     * @return EntryPresenter
     */
    public function newPresenter();

    /**
     * Return whether the title column is
     * translatable or not.
     *
     * @return bool
     */
    public function titleColumnIsTranslatable();

    /**
     * Return whether or not the assignment for
     * the given field slug is translatable.
     *
     * @param $fieldSlug
     * @return bool
     */
    public function assignmentIsTranslatable($fieldSlug);

    /**
     * Return whether or not the assignment for
     * the given field slug is a relationship.
     *
     * @param $fieldSlug
     * @return bool
     */
    public function assignmentIsRelationship($fieldSlug);

    /**
     * Set an attribute value.
     *
     * @param  $key
     * @param  $value
     * @return $this
     */
    public function setAttribute($key, $value);

    /**
     * Get an attribute value.
     *
     * @param  $key
     * @return mixed
     */
    public function getAttribute($key);

    /**
     * Get a raw unmodified attribute.
     *
     * @param      $key
     * @param bool $process
     * @return mixed|null
     */
    public function getRawAttribute($key, $process = true);

    /**
     * Set a raw unmodified attribute.
     *
     * @param $key
     * @param $value
     * @return $this
     */
    public function setRawAttribute($key, $value);

    /**
     * Get the entry attributes.
     *
     * @return array
     */
    public function getAttributes();

    /**
     * Flush the entry model's cache.
     *
     * @return EntryInterface
     */
    public function flushCache();

    /**
     * Fire field type events.
     *
     * @param       $trigger
     * @param array $payload
     */
    public function fireFieldTypeEvents($trigger, $payload = []);
}
