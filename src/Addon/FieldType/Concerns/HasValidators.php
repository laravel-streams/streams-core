<?php

namespace Anomaly\Streams\Platform\Addon\FieldType\Concerns;

/**
 * Trait HasValidators
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
trait HasValidators
{

    /**
     * Custom validators.
     * i.e. 'rule' => ['message', 'handler']
     *
     * @var array
     */
    public $validators = [];

    /**
     * Return the validators.
     *
     * @param array $validators
     * @return array
     */
    public function validators(array $validators = [])
    {
        return array_unique(array_merge($this->validators, $validators));
    }

    /**
     * Merge validators.
     *
     * @param  array $validators
     * @return $this
     */
    public function mergeValidators(array $validators)
    {
        $this->validators = array_merge($this->validators, $validators);

        return $this;
    }
}
