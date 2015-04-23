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
        'folder-closed' => 'glyphicons glyphicons-folder-closed',
        'folder-open'   => 'glyphicons glyphicons-folder-open',
        'credit-card'   => 'glyphicons glyphicons-credit-card',
        'eyedropper'    => 'glyphicons glyphicons-eyedropper',
        'fullscreen'    => 'glyphicons glyphicons-fullscreen',
        'airplane'      => 'glyphicons glyphicons-airplane',
        'retweet'       => 'glyphicons glyphicons-retweet',
        'global'        => 'glyphicons glyphicons-global',
        'globe'         => 'glyphicons glyphicons-globe',
        'redo'          => 'glyphicons glyphicons-redo',
        'external-link' => 'fa fa-external-link',
        'cloud-upload'  => 'fa fa-cloud-upload',
        'newspaper'     => 'fa fa-newspaper-o',
        'rss-square'    => 'fa fa-rss-square',
        'map-marker'    => 'fa fa-map-marker',
        'power-off'     => 'fa fa-power-off',
        'dashboard'     => 'fa fa-dashboard',
        'compress'      => 'fa fa-compress',
        'list-alt'      => 'fa fa-list-alt',
        'arrows-h'      => 'fa fa-arrows-h',
        'arrows-v'      => 'fa fa-arrows-v',
        'envelope'      => 'fa fa-envelope',
        'sitemap'       => 'fa fa-sitemap',
        'options'       => 'fa fa-options',
        'refresh'       => 'fa fa-refresh',
        'warning'       => 'fa fa-warning',
        'repeat'        => 'fa fa-repeat',
        'laptop'        => 'fa fa-laptop',
        'upload'        => 'fa fa-upload',
        'search'        => 'fa fa-search',
        'pencil'        => 'fa fa-pencil',
        'expand'        => 'fa fa-expand',
        'phone'         => 'fa fa-phone',
        'users'         => 'fa fa-users',
        'trash'         => 'fa fa-trash',
        'check'         => 'fa fa-check',
        'star'          => 'fa fa-star',
        'code'          => 'fa fa-code',
        'save'          => 'fa fa-save',
        'cog'           => 'fa fa-cog',
        'rss'           => 'fa fa-rss',
        'tag'           => 'fa fa-tag'
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
