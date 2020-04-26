<?php

namespace Anomaly\Streams\Platform\Stream\Contract;

use Anomaly\Streams\Platform\Field\Contract\FieldInterface;

/**
 * Interface StreamInterface
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
interface StreamInterface
{

    /**
     * Get the sortable flag.
     *
     * @return bool
     */
    public function isSortable();

    /**
     * Get the searchable flag.
     *
     * @return bool
     */
    public function isSearchable();

    /**
     * Get the trashable flag.
     *
     * @return bool
     */
    public function isTrashable();

    /**
     * Get the versionable flag.
     *
     * @return bool
     */
    public function isVersionable();

    /**
     * Get the translatable flag.
     *
     * @return bool
     */
    public function isTranslatable();

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
     * Get an by it's field's slug.
     *
     * @param  $slug
     * @return FieldInterface
     */
    public function getField($slug);

    /**
     * Return whether a stream
     * has a field assigned.
     *
     * @param $slug
     * @return bool
     */
    public function hasField($slug);
}
