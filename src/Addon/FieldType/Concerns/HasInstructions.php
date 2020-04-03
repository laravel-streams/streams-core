<?php

namespace Anomaly\Streams\Platform\Addon\FieldType\Concerns;

/**
 * Trait HasInstructions
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
trait HasInstructions
{

    /**
     * The field instructions.
     *
     * @var null|string
     */
    protected $instructions = null;

    /**
     * Set the instructions.
     *
     * @param $instructions
     * @return $this
     */
    public function setInstructions($instructions)
    {
        $this->instructions = $instructions;

        return $this;
    }

    /**
     * Get the instructions.
     *
     * @return null|string
     */
    public function getInstructions()
    {
        return $this->instructions;
    }
}
