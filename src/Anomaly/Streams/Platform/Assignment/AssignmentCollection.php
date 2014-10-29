<?php namespace Anomaly\Streams\Platform\Assignment;

use Anomaly\Streams\Platform\Collection\EloquentCollection;

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

            if ($type = $item->type() and (method_exists($type, 'relation') or method_exists($type, 'relations'))) {

                $relations[] = $item;

            }
        }

        return self::make($relations);
    }

}
