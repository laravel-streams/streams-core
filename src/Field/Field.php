<?php

namespace Anomaly\Streams\Platform\Field;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeBuilder;
use Anomaly\Streams\Platform\Traits\HasMemory;

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

    public $name;
    public $slug;
    public $type;
    public $stream;
    public $warning;
    public $placeholder;
    public $instructions;
    public $searchable = true;
    public $translatable = false;
    public $config = [];
    public $rules = [];

    /**
     * Create a new Field instance.
     *
     * @param array $field
     */
    public function __construct(array $field)
    {
        foreach ($field as $attribute => $value) {
            $this->{$attribute} = $value;
        }
    }

    /**
     * Return the field type.
     * 
     * @return FieldType
     */
    public function type()
    {
        return $this->remember($this->type, function () {
            return FieldTypeBuilder::build([
                'type' => $this->type,
            ]);
        });
    }

    /**
     * Get the name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the warning.
     *
     * @return string
     */
    public function getWarning()
    {
        return $this->warning;
    }

    /**
     * Get the instructions.
     *
     * @return string
     */
    public function getInstructions()
    {
        return $this->instructions;
    }

    /**
     * Get the instructions.
     *
     * @return string
     */
    public function getPlaceholder()
    {
        return $this->placeholder;
    }

    /**
     * Get the stream.
     *
     * @return string
     */
    public function getStream()
    {
        return $this->stream;
    }

    /**
     * Get the slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Get the field type.
     *
     * @return FieldType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get the configuration.
     *
     * @return mixed
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Return whether the field is
     * a relationship or not.
     *
     * @return bool
     */
    public function isRelationship()
    {
        $this->relationship;
    }

    /**
     * Get the locked flag.
     *
     * @return bool
     */
    public function isLocked()
    {
        $this->locked;
    }

    /**
     * Get the rules.
     *
     * @return array
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * Get the searchable flag.
     *
     * @return bool
     */
    public function isSearchable()
    {
        return $this->searchable;
    }

    /**
     * Get the translatable flag.
     *
     * @return bool
     */
    public function isTranslatable()
    {
        return $this->translatable;
    }
}
