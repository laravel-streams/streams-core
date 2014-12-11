<?php namespace Anomaly\Streams\Platform\Ui\Table\Button;

class Button extends \Anomaly\Streams\Platform\Ui\Button\Button
{

    function __construct(
        $href = null,
        $text = null,
        $icon = null,
        $class = null,
        $type = 'default',
        array $attributes = []
    ) {
        parent::__construct($type, $text, $class, $icon, $attributes);

        if ($href) {

            $this->putAttribute('href', $href);
        }
    }
}
 