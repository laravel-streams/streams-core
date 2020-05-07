<?php

namespace Anomaly\Streams\Platform\Ui\Form\Component\Action;

use Anomaly\Streams\Platform\Ui\Button\Button;

/**
 * Class Action
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Action extends Button
{

    /**
     * The button attributes.
     *
     * @var array
     */
    protected $attributes = [
        'tag' => 'button',
        'url' => null,
        'text' => null,
        'entry' => null,
        'policy' => null,
        'enabled' => true,
        'primary' => false,
        'disabled' => false,
        'type' => 'default',

        // Extended
        'prefix' => null,
        'redirect' => null,

        'save' => true,
        'active' => false,

        'slug' => 'default',
        'handler' => ActionHandler::class,
    ];

    /**
     * Return merged attributes.
     *
     * @param array $attributes
     */
    public function attributes(array $attributes = [])
    {
        return array_merge(parent::attributes(), [
            'class' => $this->class,
            'value' => $this->slug,
            'type'  => $this->type,
            'name'  => 'action',
        ], $attributes);
    }
}
