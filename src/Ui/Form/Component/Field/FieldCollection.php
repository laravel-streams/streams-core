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
     * @return FieldCollection
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
            if ($item->getInputName() == $key) {
                return $item;
            }
        }

        return $this->get($default);
    }

    /**
     * Return only translatable fields.
     *
     * @return FieldCollection
     */
    public function translatable()
    {
        $translatable = [];

        /* @var FieldType $item */
        foreach ($this->items as $item) {
            if (!$item->getLocale()) {
                $translatable[] = $item;
            }
        }

        return new static($translatable);
    }

    /**
     * Return fields to be processed immediately.
     *
     * @return FieldCollection
     */
    public function immediate()
    {
        $immediate = [];

        /* @var FieldType $item */
        foreach ($this->items as $item) {
            if (!$item->isDeferred()) {
                $immediate[] = $item;
            }
        }

        return new static($immediate);
    }

    /**
     * Return fields to be processed later.
     *
     * @return FieldCollection
     */
    public function deferred()
    {
        $immediate = [];

        /* @var FieldType $item */
        foreach ($this->items as $item) {
            if ($item->isDeferred()) {
                $immediate[] = $item;
            }
        }

        return new static($immediate);
    }

    /**
     * Return enabled fields.
     *
     * @return FieldCollection
     */
    public function enabled()
    {
        $enabled = [];

        /* @var FieldType $item */
        foreach ($this->items as $item) {
            if (!$item->isDisabled()) {
                $enabled[] = $item;
            }
        }

        return new static($enabled);
    }

    /**
     * Skip a field.
     *
     * @param $fieldSlug
     */
    public function skip($fieldSlug)
    {
        $this->forget($fieldSlug);
    }

    /**
     * Forget a key.
     *
     * @param mixed $key
     */
    public function forget($key)
    {
        /* @var FieldType $item */
        foreach ($this->items as $index => $item) {
            if ($item->getField() == $key) {

                unset($this->items[$index]);

                break;
            }
        }
    }
}
