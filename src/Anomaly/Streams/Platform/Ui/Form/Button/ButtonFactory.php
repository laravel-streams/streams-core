<?php namespace Anomaly\Streams\Platform\Ui\Form\Button;

use Anomaly\Streams\Platform\Ui\Form\Button\Contract\ButtonRepositoryInterface;

class ButtonFactory
{

    protected $buttons;

    function __construct(ButtonRepositoryInterface $buttons)
    {
        $this->buttons = $buttons;
    }

    public function make(array $parameters)
    {
        if (isset($parameters['button']) and class_exists($parameters['button'])) {

            return app()->make($parameters['button'], $parameters);
        }

        if ($button = array_get($parameters, 'button') and $button = $this->buttons->find($button)) {

            $button = array_merge($button, array_except($parameters, 'button'));

            return app()->make($button['button'], $button);
        }

        return app()->make('Anomaly\Streams\Platform\Ui\Form\Button\Button', $parameters);
    }
}
 