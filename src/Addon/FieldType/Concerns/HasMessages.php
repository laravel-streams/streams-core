<?php

namespace Anomaly\Streams\Platform\Addon\FieldType\Concerns;

/**
 * Trait HasMessages
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
trait HasMessages
{

    /**
     * Custom validation messages.
     * i.e. 'rule' => ['rule', 'message']
     *
     * @var array
     */
    public $messages = [];

    /**
     * Get the messages.
     *
     * @return array
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * Merge messages.
     *
     * @param  array $messages
     * @return $this
     */
    public function mergeMessages(array $messages)
    {
        $this->messages = array_merge($this->messages, $messages);

        return $this;
    }
}
