<?php namespace Streams\Core\Assignment\Collection;

use Streams\Core\Collection\EloquentCollection;

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

    /**
     * Return fields less skips.
     *
     * @param $skips
     * @return static
     */
    public function skip($skips)
    {
        $fields = [];

        foreach ($this->items as $item) {
            if (!in_array($item->slug, $skips)) {
                $fields[] = $item;
            }
        }

        return self::make($fields);
    }
}
