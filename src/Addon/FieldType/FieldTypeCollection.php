<?php

namespace Anomaly\Streams\Platform\Addon\FieldType;

use Anomaly\Streams\Platform\Addon\AddonCollection;

/**
 * Class FieldTypeCollection
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class FieldTypeCollection extends AddonCollection
{

    /**
     * Get a field type from the
     * collection by namespace key.
     *
     * @param  mixed $key
     * @param  mixed $default
     * @return null|FieldType
     */
    public function get($key, $default = null)
    {
        $type = $this->instance($key);

        if (!$type) {
            return $default;
        }

        return clone ($type);
    }

    /**
     * Find an addon by it's slug.
     *
     * @param  string $slug
     * @param bool $instance
     *
     * @return null|FieldType
     */
    public function findBySlug(string $slug, $instance = true)
    {
        if (!$addon = parent::findBySlug($slug, $instance)) {
            return null;
        }

        return is_array($addon) ? $addon : clone ($addon);
    }
}
