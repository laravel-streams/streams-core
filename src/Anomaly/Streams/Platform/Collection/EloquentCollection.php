<?php namespace Anomaly\Streams\Platform\Collection;

use Illuminate\Database\Eloquent\Collection;

/**
 * Class EloquentCollection
 * The base eloquent collection used by all our models.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Collection
 */
class EloquentCollection extends Collection
{

    /**
     * Find by slug.
     *
     * This is not always applicable but
     * many streams utilize a slug.
     *
     * @param $slug
     * @return null
     */
    public function findBySlug($slug)
    {
        foreach ($this->items as $item) {

            if ($item->slug == $slug) {

                return $item;

            }

        }

        return null;
    }

    /**
     * Return a collection of decorated items.
     *
     * @return static
     */
    public function decorated()
    {
        $items = [];

        $decorator = app('streams.decorator');

        foreach ($this->items as $item) {

            $items[] = $decorator->decorate($item);

        }

        return self::make($items);
    }

}
