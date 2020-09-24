<?php

namespace Anomaly\Streams\Platform\Field;

use Illuminate\Support\Collection;

/**
 * Class FieldCollection
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class FieldCollection extends Collection
{

    /**
     * Return field handles.
     * 
     * @param null $prefix
     * @return FieldCollection
     */
    public function handles($prefix = null)
    {
        return $this->map(function ($field) use ($prefix) {
            return ($prefix ?: null) . $field->handle;
        });
    }

    /**
     * Return translatable fields.
     * 
     * @return FieldCollection
     */
    public function translatable($translatable = true)
    {
        return $this->filter(function ($field) use ($translatable) {
            return $field->translatable === $translatable ? $field : null;
        });
    }

    /**
     * Return translatable fields.
     * 
     * @return FieldCollection
     */
    public function dates($translatable = true)
    {
        return $this->filter(function ($field) use ($translatable) {
            return $field->translatable === $translatable ? $field : null;
        });
    }

    /**
     * Return the rules for all fields.
     * 
     * @return array
     */
    public function rules()
    {
        return array_filter(
            array_combine($this->keys()->all(), $this->map(function ($field) {
                return $field->rules;
            })->all())
        );
    }

    /**
     * Return the validators for all fields.
     * 
     * @return array
     */
    public function validators()
    {
        return array_filter(
            array_combine($this->keys()->all(), $this->map(function ($field) {
                return $field->validators;
            })->all())
        );
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
}
