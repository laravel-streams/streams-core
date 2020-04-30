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
    public $rules = [];

    /**
     * Return the rules.
     *
     * @param array $rules
     * @return array
     */
    public function rules(array $rules = [])
    {
        return array_unique(array_merge($this->rules, $rules));
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
