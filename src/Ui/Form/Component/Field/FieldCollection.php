<?php

namespace Anomaly\Streams\Platform\Ui\Form\Component\Field;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Illuminate\Support\Collection;

/**
 * Class FieldCollection
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class FieldCollection extends Collection
{

    /**
     * Return base fields only.
     * No translations.
     *
     * @return FieldCollection
     */
    public function base()
    {
        $fields = [];

        $locale = config('streams.locales.default');

        /* @var FieldType $item */
        foreach ($this->items as $item) {

            // If it's the base local then add it.
            if ($item->locale == $locale) {
                $fields[] = $item;
            }

            // If there is no locale then add it.
            if ($item->locale === null) {
                $fields[] = $item;
            }
        }

        return new static($fields);
    }

    /**
     * Return all translations for a field.
     *
     * @param $field
     * @return FieldCollection
     */
    public function translations($field)
    {
        return $this->filter(function ($item) use ($field) {
            return $item->field_name == $field;
        });
    }

    /**
     * Get a field.
     *
     * @param  mixed $key
     * @param  null $default
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

        if (!$default) {
            return $default;
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
        return $this->filter(function ($item) {
            return $item->translatable;
        });
    }

    /**
     * Return only fields of given locale.
     *
     * @param string $locale
     * @return FieldCollection
     */
    public function locale($locale)
    {
        return $this->filter(function ($item) use ($locale) {
            return $item->locale == $locale;
        });
    }

    /**
     * Return only NON translatable fields.
     *
     * @return FieldCollection
     */
    public function notTranslatable()
    {
        return $this->filter(function ($item) {
            return !$item->translatable;
        });
    }

    /**
     * Return enabled fields.
     *
     * @return FieldCollection
     */
    public function enabled()
    {
        return $this->filter(function ($item) {
            return $item->enabled;
        });
    }

    /**
     * Return disabled fields.
     *
     * @return FieldCollection
     */
    public function disabled()
    {
        return $this->filter(function ($item) {
            return !$item->enabled;
        });
    }

    /**
     * Return writable fields.
     *
     * @return FieldCollection
     */
    public function writable()
    {
        return $this->filter(function ($item) {
            return !$item->readonly;
        });
    }

    /**
     * Return readonly fields.
     *
     * @return FieldCollection
     */
    public function readonly()
    {
        return $this->filter(function ($item) {
            return $item->readonly;
        });
    }

    /**
     * Return auto handling fields.
     *
     * @return FieldCollection
     */
    public function autoHandling()
    {
        return $this->filter(function ($item) {
            return !method_exists($item, 'handle');
        });
    }

    /**
     * Return self handling fields.
     *
     * @return FieldCollection
     */
    public function selfHandling()
    {
        return $this->filter(function ($item) {
            return method_exists($item, 'handle');
        });
    }

    /**
     * Return only savable fields.
     *
     * @return FieldCollection
     */
    public function savable()
    {
        return $this->filter(function ($item) {
            return $item->save;
        });
    }

    /**
     * Return only non-savable fields.
     *
     * @return FieldCollection
     */
    public function nonSavable()
    {
        return $this->filter(function ($item) {
            return !$item->save;
        });
    }

    /**
     * Forget a key.
     * 
     * @todo This should be renamed as it has different logical expectations here.
     *
     * @param mixed $key
     */
    public function forget($key)
    {
        foreach ($this->items as $index => $item) {

            if ($item->field == $key) {

                unset($this->items[$index]);

                break;
            }
        }
    }

    /**
     * Return a unique array of field slugs
     * for all the fields in the collection.
     *
     * @return array
     */
    public function slugs()
    {
        return $this->map(function ($field) {
            return $field->field;
        });
    }

    /**
     * Return an array of field names
     * for all the fields in the collection.
     *
     * @return static
     */
    public function names()
    {
        return $this->map(function ($field) {
            return $field->field_name;
        });
    }

    /**
     * Map attributes to get.
     *
     * @param string $key
     */
    public function __get($key)
    {
        return $this->get($key);
    }

    /**
     * Return the field partial.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->map(function ($item) {
            return $item->render();
        })->implode("\n");
    }
}
