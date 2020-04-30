<?php

namespace Anomaly\Streams\Platform\Addon\FieldType\Concerns;

/**
 * Trait HasErrors
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
trait HasErrors
{

    /**
     * Validation errors.
     *
     * @var array
     */
    public $errors = [];

    /**
     * Get the errors.
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Set errors.
     *
     * @param  array $errors
     * @return $this
     */
    public function setErrors(array $errors)
    {
        $this->errors = $errors;

        return $this;
    }

    /**
     * Return if the field
     * has errors or not.
     *
     * @return bool
     */
    public function hasErrors()
    {
        return !empty($this->errors);
    }

    /**
     * Merge errors.
     *
     * @param  array $errors
     * @return $this
     */
    public function mergeErrors(array $errors)
    {
        $this->errors = array_unique(array_merge($this->errors, $errors));

        return $this;
    }
}
