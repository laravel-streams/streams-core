<?php

namespace Anomaly\Streams\Platform\Field;

use Anomaly\Streams\Platform\Traits\HasMemory;
use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeBuilder;
use Anomaly\Streams\Platform\Traits\HasAttributes;

/**
 * Class Field
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Field implements FieldInterface
{
    use HasMemory;
    use HasAttributes;

    /**
     * The field attributes.
     *
     * @var array
     */
    protected $attributes = [
        'name' => null,
        'slug' => null,
        'type' => null,
        'label' => null,
        'stream' => null,
        'warning' => null,
        'placeholder' => null,
        'instructions' => null,

        'unique' => false,
        'required' => false,
        'searchable' => true,
        'translatable' => false,

        'config' => [],
        'rules' => [],
    ];

    /**
     * Create a new Field instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        $this->setAttributes(array_merge($this->attributes, $attributes));
    }

    /**
     * Return the type instance.
     * 
     * @return FieldType
     */
    public function type()
    {
        return $this->remember($this->slug . '.' . $this->type, function () {

            $type = FieldTypeBuilder::build($this->type);

            $type->setField($this->slug);
            $type->mergeRules($this->rules);
            $type->mergeConfig($this->config);

            if (isset($this->stream->model->id)) {
                $type->setEntry($this->stream->model);
            }

            return $type;
        });
    }

    /**
     * Dynamically retrieve attributes.
     *
     * @param  string $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->getAttribute($key);
    }

    /**
     * Dynamically set attributes.
     *
     * @param  string  $key
     * @param  mixed $value
     */
    public function __set($key, $value)
    {
        $this->setAttribute($key, $value);
    }
}
