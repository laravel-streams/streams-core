<?php namespace Anomaly\Streams\Platform\Ui\Table\Button;

/**
 * Class ButtonFactory
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Button
 */
class ButtonFactory
{

    /**
     * The default button class.
     *
     * @var string
     */
    protected $button = 'Anomaly\Streams\Platform\Ui\Table\Button\Button';

    /**
     * The button repository.
     *
     * @var ButtonRepository
     */
    protected $buttons;

    /**
     * Create a new ButtonFactory instance.
     *
     * @param ButtonRepository $buttons
     */
    public function __construct(ButtonRepository $buttons)
    {
        $this->buttons = $buttons;
    }

    /**
     * Make a button.
     *
     * @param  array $parameters
     * @return mixed
     */
    public function make(array $parameters)
    {
        if ($button = $this->buttons->find(array_get($parameters, 'button'))) {
            $parameters = array_replace_recursive($button, array_except($parameters, 'button'));
        }

        return app()->make(array_get($parameters, 'button', $this->button), $parameters);
    }
}
