<?php

namespace Anomaly\Streams\Platform\Ui\Button;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Lang;
use Anomaly\Streams\Platform\Ui\Button\Button;
use Anomaly\Streams\Platform\Support\Facades\Hydrator;

/**
 * Class ButtonFactory
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class ButtonFactory
{

    /**
     * The default button class.
     *
     * @var string
     */
    protected $button = Button::class;

    /**
     * The button registry.
     *
     * @var ButtonRegistry
     */
    protected $buttons;

    /**
     * The translator utility.
     *
     * @var Translator
     */
    protected $translator;

    /**
     * Create a new ButtonFactory instance.
     *
     * @param ButtonRegistry $buttons
     */
    public function __construct(ButtonRegistry $buttons)
    {
        $this->buttons = $buttons;
    }

    /**
     * Make a button.
     *
     * @param  array $parameters
     * @return ButtonInterface
     */
    public function make(array $parameters)
    {
        $button = Arr::get($parameters, 'button');

        if ($button && $registered = $this->buttons->get($button)) {
            $parameters = array_replace_recursive($registered, Arr::except($parameters, 'button'));
        }

        $parameters = Lang::translate($parameters);

        if (!Arr::get($parameters, 'button') || !class_exists(Arr::get($parameters, 'button'))) {
            Arr::set($parameters, 'button', $this->button);
        }

        /* @var Button$button */
        $class = Arr::get($parameters, 'button');

        $button = new $class($parameters);

        Hydrator::hydrate($button, $parameters);

        if ($button->policy) {
            $button->setEnabled(Gate::any((array) $button->policy));
        }

        return $button;
    }
}
