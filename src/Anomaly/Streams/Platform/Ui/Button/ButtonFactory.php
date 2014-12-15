<?php namespace Anomaly\Streams\Platform\Ui\Button;

/**
 * Class ButtonFactory
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Button
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
     * The available button default.
     *
     * @var array
     */
    protected $buttons = [
        'cancel' => [
            'text' => 'streams::button.cancel',
            'type' => 'default',
        ],
        'edit'   => [
            'text' => 'streams::button.edit',
            'type' => 'warning',
        ],
        'delete' => [
            'text' => 'streams::button.delete',
            'type' => 'danger',
        ],
    ];

    /**
     * Make a button.
     *
     * @param array $parameters
     * @return mixed
     */
    public function make(array $parameters)
    {
        if (isset($parameters['button']) && class_exists($parameters['button'])) {
            return app()->make($parameters['button'], $parameters);
        }

        if ($button = array_get($this->buttons, array_get($parameters, 'button'))) {
            $parameters = array_replace_recursive($button, array_except($parameters, 'button'));
        }

        return app()->make($this->button, $parameters);
    }
}
