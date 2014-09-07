<?php namespace Streams\Core\Assignment\Collection;

use Streams\Core\Collection\EloquentCollection;

class AssignmentCollection extends EloquentCollection
{
    /**
     * Find an item by slug.
     *
     * @param $slug
     * @return null
     */
    public function findBySlug($slug)
    {
        foreach ($this->items as $item) {
            if ($item->field->slug == $slug) {
                return $item;
            }
        }

        return null;
    }

    /**
     * Return the field slugs in
     *
     * @return array
     */
    public function fieldSlugs()
    {
        $slugs = [];

        foreach ($this->items as $item) {
            $slugs[] = $item->field->slug;
        }

        return $slugs;
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
            if (method_exists($item->type, 'relation') or method_exists($item->type, 'relations')) {
                $relations[] = $item;
            }
        }

        return self::make($relations);
    }
}
