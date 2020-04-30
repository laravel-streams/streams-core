<?php

namespace Anomaly\Streams\Platform\Field\Contract;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;

/**
 * Interface FieldInterface
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
interface FieldInterface
{

    /**
     * Return the field's type.
     *
     * @return FieldType
     */
    public function type();

    /**
     * Get the name.
     *
     * @return string
     */
    public function getName();

    /**
     * Get the warning.
     *
     * @return string
     */
    public function getWarning();

    /**
     * Get the stream.
     *
     * @return string
     */
    public function getStream();

    /**
     * Get the slug.
     *
     * @return string
     */
    public function getSlug();

    /**
     * Get the field type.
     *
     * @return FieldType
     */
    public function getType();

    /**
     * Get the configuration.
     *
     * @return mixed
     */
    public function getConfig();

    /**
     * Return whether the field is
     * a relationship or not.
     *
     * @return bool
     */
    public function isRelationship();

    /**
     * Get the locked flag.
     *
     * @return bool
     */
    public function isLocked();

    /**
     * Get the rules.
     *
     * @return array
     */
    public function getRules();
}
