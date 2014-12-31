<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Field;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Illuminate\Support\Collection;

/**
 * Class FieldCollection
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Field
 */
class FieldCollection extends Collection
{

    /**
     * Return fields only of a certain locale.
     *
     * @param $locale
     * @return static
     */
    public function locale($locale)
    {
        $items = [];

        foreach ($this->items as $slug => $item) {
            if ($item instanceof FieldType && $item->getLocale() == $locale) {
                $items[$slug] = $item;
            }
        }

        return new static($items);
    }

    /**
     * Return an array of field slugs.
     *
     * @return array
     */
    public function fieldSlugs()
    {
        $slugs = [];

        foreach ($this->items as $item) {
            if ($item instanceof FieldType && $slug = $item->getField()) {
                $slugs[] = $slug;
            }
        }

        return $slugs;
    }
}
