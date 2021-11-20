<?php

namespace Streams\Core\Entry\Contract;

use Streams\Core\Stream\Stream;

interface EntryInterface
{

    /**
     * Return the Stream definition.
     *
     * @var Stream
     */
    public function stream();

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
     * Expand the field value.
     *
     * @param string $key
     * @var \Streams\Core\Field\Value\Value
     */
    public function expand($key);

    /**
     * Save the entry.
     * 
     * @param array $options
     * @var bool
     */
    public function save(array $options = []);

    /**
     * Delete the entry.
     * 
     * @return bool
     */
    public function delete();
}
