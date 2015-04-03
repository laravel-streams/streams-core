<?php namespace Anomaly\Streams\Platform\Ui\Icon;

/**
 * Class IconRegistry
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Icon
 */
class IconRegistry
{

    /**
     * Available icon.
     *
     * @var array
     */
    protected $icons = [
        'glyphicons' => 'glyphicons glyphicons-eyedropper',
        'dashboard'  => 'fa fa-dashboard',
        'options'    => 'fa fa-options',
        'users'      => 'fa fa-users',
        'cog'        => 'fa fa-cog'
    ];

    /**
     * Get a button.
     *
     * @param  $icon
     * @return array|null
     */
    public function get($icon)
    {
        return array_get($this->icons, $icon, $icon);
    }

    /**
     * Register a button.
     *
     * @param       $icon
     * @param array $parameters
     * @return $this
     */
    public function register($icon, array $parameters)
    {
        array_set($this->icons, $icon, $parameters);

        return $this;
    }
}
