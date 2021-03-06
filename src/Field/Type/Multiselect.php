<?php

namespace Streams\Core\Field\Type;

use Illuminate\Support\Arr;

class Multiselect extends Select
{
    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializePrototypeAttributes(array $attributes)
    {
        return parent::initializePrototypeAttributes(array_merge([
            'rules' => [
                //'in_options',
            ],
        ], $attributes));
    }
    
    public function setValueAttribute($value)
    {
        if (
            isset($value)
            && is_string($value)
            && $json = json_decode($value, true)
            ) {
                $value = $json;
        }

        $this->setPrototypeAttributeValue('value', $value);
    }

    /**
     * Modify the value for storage.
     *
     * @param string $value
     * @return string
     */
    public function modify($value)
    {
        return (array) $value;
    }

    /**
     * Restore the value from storage.
     *
     * @param $value
     * @return string
     */
    public function restore($value)
    {
        return (array) $value;
    }

    public function options()
    {
        return Arr::get($this->field->config, 'options', []);
    }
}
