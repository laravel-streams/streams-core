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
     * Return fields matching the given field.
     *
     * @param $field
     * @return mixed
     */
    public function fields($field)
    {
        $fields = [];

        foreach ($this->items as $item) {
            if ($item instanceof FieldType && $item->getField() == $field) {
                $fields[] = $item;
            }
        }

        return new static($fields);
    }

    /**
     * Get a field.
     *
     * @param mixed $key
     * @param null  $default
     * @return FieldType
     */
    public function get($key, $default = null)
    {
        /* @var FieldType $item */
        foreach ($this->items as $item) {
            if ($item->getField() == $key) {
                return $item;
            }
        }

        return $this->get($default);
    }

    /**
     * Return fields to be processed immediately.
     *
     * @return static
     */
    public function immediate()
    {
        $immediate = [];

        foreach ($this->items as $item) {
            if ($item instanceof FieldType && !$item->isDeferred()) {
                $immediate[] = $item;
            }
        }

        return new static($immediate);
    }

    /**
     * Return fields to be processed later.
     *
     * @return static
     */
    public function deferred()
    {
        $immediate = [];

        foreach ($this->items as $item) {
            if ($item instanceof FieldType && $item->isDeferred()) {
                $immediate[] = $item;
            }
        }

        return new static($immediate);
    }
}
