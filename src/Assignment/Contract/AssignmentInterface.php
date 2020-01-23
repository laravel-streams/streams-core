<?php

namespace Anomaly\Streams\Platform\Assignment\Contract;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
use Anomaly\Streams\Platform\Model\Contract\EloquentInterface;
use Anomaly\Streams\Platform\Model\EloquentCollection;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Interface AssignmentInterface
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
interface AssignmentInterface extends EloquentInterface
{

    /**
     * Get the ID.
     *
     * @return null|integer
     */
    public function getId();

    /**
     * Get the related stream.
     *
     * @return StreamInterface
     */
    public function getStream();

    /**
     * Get the related stream's slug.
     *
     * @return string
     */
    public function getStreamSlug();

    /**
     * Get the related stream's prefix.
     *
     * @return string
     */
    public function getStreamPrefix();

    /**
     * Get the related field.
     *
     * @return FieldInterface
     */
    public function getField();

    /**
     * Get the related field ID.
     *
     * @return null|int
     */
    public function getFieldId();

    /**
     * Get the label.
     *
     * @return string
     */
    public function getLabel();

    /**
     * Get the warning.
     *
     * @return string
     */
    public function getWarning();

    /**
     * Get the instructions.
     *
     * @return string
     */
    public function getInstructions();

    /**
     * Get the placeholder.
     *
     * @return string
     */
    public function getPlaceholder();

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
     * Get the searchable flag.
     *
     * @return bool
     */
    public function isSearchable();

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
     * @param  bool $fresh
     * @return FieldType
     */
    public function getFieldType($fresh = false);

    /**
     * Get the field type value. This helps
     * avoid spinning up a type instance
     * if you don't really need it.
     *
     * @return string
     */
    public function getFieldTypeValue();

    /**
     * Get the assignment's field's name.
     *
     * @return string
     */
    public function getFieldName();

    /**
     * Get the assignment's field's config.
     *
     * @return string
     */
    public function getFieldConfig();

    /**
     * Get the assignment's field's rules.
     *
     * @return array
     */
    public function getFieldRules();

    /**
     * Get the column name.
     *
     * @return mixed
     */
    public function getColumnName();

    /**
     * Get all attributes.
     *
     * @return mixed
     */
    public function getAttributes();
}
