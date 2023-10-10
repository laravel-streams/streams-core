<?php

namespace Streams\Core\Entry\Contract;

use Streams\Core\Stream\Stream;
use Streams\Core\Field\FieldDecorator;

interface EntryInterface
{
    public function stream(): Stream;

    /**
     * Return the entry attributes.
     *
     * @var array
     */
    public function getAttributes();

    /**
     * Return the entry attribute.
     *
     * @param string $key
     * @var array
     */
    public function getAttribute($key);

    /**
     * Return if the entry has a given attribute.
     *
     * @param string $key
     * @var bool
     */
    public function hasAttribute($key);
    
    /**
     * Return the last modified date if possible.
     *
     * @var \DatetimeInterface|null
     */
    public function lastModified();

    /**
     * Set the entry attributes.
     *
     * @param array $attributes
     */
    public function setAttributes(array $attributes);

    /**
     * @return bool
     */
    public function save(array $options = []);

    public function decorate(string $field): FieldDecorator;
}
