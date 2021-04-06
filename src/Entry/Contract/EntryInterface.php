<?php

namespace Streams\Core\Entry\Contract;

use Streams\Core\Stream\Stream;

/**
 * Interface EntryInterface
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
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
     * @var bool
     */
    public function delete();
}
