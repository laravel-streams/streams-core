<?php

namespace Anomaly\Streams\Platform\Field;

use Anomaly\Streams\Platform\Field\Contract\FieldInterface;

/**
 * Class Field
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Field implements FieldInterface
{

    protected $name;
    protected $slug;
    protected $type;
    protected $stream;
    protected $warning;
    protected $instructions;
    protected $placeholder;
    protected $config = [];
    protected $rules = [];

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
}
