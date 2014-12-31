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
     * Return fields only in a given section.
     *
     * @param string $section
     * @return static
     */
    public function section($section = 'default')
    {
        $fields = [];

        foreach ($this->items as $item) {
            if ($item instanceof FieldType && $item->getSection() == $section) {
                $fields[] = $item;
            }
        }

        return new static($fields);
    }
}
