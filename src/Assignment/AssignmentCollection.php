<?php namespace Anomaly\Streams\Platform\Assignment;

use Anomaly\Streams\Platform\Addon\FieldType\Contract\DateFieldTypeInterface;
use Anomaly\Streams\Platform\Addon\FieldType\Contract\RelationFieldTypeInterface;
use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
use Anomaly\Streams\Platform\Model\EloquentCollection;

/**
 * Class AssignmentCollection
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Assignment
 */
class AssignmentCollection extends EloquentCollection
{

    /**
     * Find an assignment by it's field slug.
     *
     * @param  $slug
     * @return FieldInterface
     */
    public function findByFieldSlug($slug)
    {
        foreach ($this->items as $item) {
            if ($item->getFieldSlug() == $slug) {
                return $item;
            }
        }

        return null;
    }

    /**
     * Return only assignments that have relation fields.
     *
     * @return static
     */
    public function relations()
    {
        $relations = [];

        foreach ($this->items as $item) {
            $type = $item->getFieldType();

            if ($type instanceof RelationFieldTypeInterface) {
                $relations[] = $item;
            }
        }

        return self::make($relations);
    }

    /**
     * Return only assignments that have date fields.
     *
     * @return static
     */
    public function dates()
    {
        $dates = [];

        foreach ($this->items as $item) {
            $type = $item->getFieldType();

            if ($type instanceof DateFieldTypeInterface) {
                $dates[] = $item;
            }
        }

        return self::make($dates);
    }
}
