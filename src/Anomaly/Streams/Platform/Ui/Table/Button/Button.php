<?php namespace Anomaly\Streams\Platform\Ui\Table\Button;

/**
 * Class Button
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Button
 */
class Button extends \Anomaly\Streams\Platform\Ui\Button\Button
{
    /**
     * Create a new Button Instance.
     *
     * @param null   $href
     * @param null   $text
     * @param null   $icon
     * @param null   $class
     * @param string $type
     * @param array  $attributes
     */
    public function __construct(
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
