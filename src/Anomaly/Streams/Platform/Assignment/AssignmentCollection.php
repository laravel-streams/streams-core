<?php namespace Anomaly\Streams\Platform\Assignment;

use Anomaly\Streams\Platform\Collection\EloquentCollection;
use Anomaly\Streams\Platform\Field\Contract\FieldInterface;

/**
 * Class AssignmentCollection
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Assignment
 */
class AssignmentCollection extends EloquentCollection
{

    /**
     * Find an assignment by it's field slug.
     *
     * @param $slug
     * @return FieldInterface
     */
    public function findByFieldSlug($slug)
    {
        foreach ($this->items as $item) {

            if ($item->field->slug == $slug) {

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

            if ($type = $item->type() and $type->getRelation()) {

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

        $compatible = ['datetime', 'date'];

        foreach ($this->items as $item) {

            if ($type = $item->type() and in_array($type->getColumnType(), $compatible)) {

                $dates[] = $item;
            }
        }

        return self::make($dates);
    }
}
