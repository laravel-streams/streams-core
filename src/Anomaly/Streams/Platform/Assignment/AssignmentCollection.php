<?php namespace Anomaly\Streams\Platform\Assignment;

use Anomaly\Streams\Platform\Collection\EloquentCollection;

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
     * @return null
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
     * @return \Illuminate\Support\Collection
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
     * Return only assignments that have dates fields.
     *
     * @return static
     */
    public function dates()
    {
        $dates = [];

        foreach ($this->items as $item) {

            if ($type = $item->type() and $type->getColumnType() == 'datetime') {

                $dates[] = $item;
            }
        }

        return self::make($dates);
    }
}
