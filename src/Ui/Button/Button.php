<?php

namespace Anomaly\Streams\Platform\Ui\Button;

use Anomaly\Streams\Platform\Ui\Support\Component;

/**
 * Class Button
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Button extends Component
{

    /**
     * The button attributes.
     *
     * @var array
     */
    protected $attributes = [
        'tag' => 'a',
        'url' => null,
        'text' => null,
        'entry' => null,
        'policy' => null,
        'enabled' => true,
        'primary' => false,
        'disabled' => false,
        'type' => 'default',
    ];

    /**
     * Return the open tag.
     *
     * @param array $attributes
     * @return string
     */
    public function open(array $attributes = [])
    {
        // @todo extend into the parent when ready
        return '<' . $this->tag . ' ' . html_attributes($attributes) . '>';
    }

    /**
     * Return the close tag.
     *
     * @return string
     */
    public function close()
    {
        return '</' . $this->tag . '>';
    }
}
