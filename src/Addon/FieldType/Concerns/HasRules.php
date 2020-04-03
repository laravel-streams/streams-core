<?php

namespace Anomaly\Streams\Platform\Addon\FieldType\Concerns;

/**
 * Trait HasRules
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
trait HasRules
{

    /**
     * Validation rules.
     *
     * @var array
     */
    protected $rules = [];

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
     * Set rules.
     *
     * @param  array $rules
     * @return $this
     */
    public function setRules(array $rules)
    {
        $this->rules = $rules;

        return $this;
    }

    /**
     * Merge rules.
     *
     * @param  array $rules
     * @return $this
     */
    public function mergeRules(array $rules)
    {
        $this->rules = array_unique(array_merge($this->rules, $rules));

        return $this;
    }
}
