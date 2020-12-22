<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\FieldType;
use Streams\Core\Support\Facades\Streams;

/**
 * Class Relationship
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Relationship extends FieldType
{
    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializePrototype(array $attributes)
    {
        return parent::initializePrototype(array_merge([
            'rules' => [],
        ], $attributes));
    }

    /**
     * Expand the value.
     *
     * @param $value
     * @return EntryInterface|null
     */
    public function expand($value)
    {
        if (isset($this->config['key_name'])) {
            $value = $this->entry->{$this->config['key_name']};
        }

        return Streams::entries($this->config['related'])->find($value);
    }
}
