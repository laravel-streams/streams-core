<?php namespace Anomaly\Streams\Platform\Ui\Button;

use Anomaly\Streams\Platform\Ui\Button\Contract\ButtonInterface;

/**
 * Class ButtonFactory
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Component\Button
 */
class ButtonFactory
{

    /**
     * The default button class.
     *
     * @var string
     */
    protected $button = 'Anomaly\Streams\Platform\Ui\Button\Button';

    /**
     * The button registry.
     *
     * @var ButtonRegistry
     */
    protected $buttons;

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
        $button = array_get($parameters, 'button');

        if ($button && $button = $this->buttons->get($button)) {
            $parameters = array_replace_recursive($button, array_except($parameters, 'button'));
        }

        $button = app()->make(array_get($parameters, 'button', $this->button), $parameters);

        $this->hydrate($button, $parameters);

        return $button;
    }

    /**
     * Hydrate the button with it's remaining parameters.
     *
     * @param ButtonInterface $button
     * @param array           $parameters
     */
    protected function hydrate(ButtonInterface $button, array $parameters)
    {
        foreach ($parameters as $parameter => $value) {

            $method = camel_case('set_' . $parameter);

            if (method_exists($button, $method)) {
                $button->{$method}($value);
            }
        }
    }
}
