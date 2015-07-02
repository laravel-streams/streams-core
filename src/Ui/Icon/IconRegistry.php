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
        'circle-question-mark' => 'glyphicons glyphicons-circle-question-mark',
        'facetime-video'       => 'glyphicons glyphicons-facetime-video',
        'shopping-cart'        => 'glyphicons glyphicons-shopping-cart',
        'folder-closed'        => 'glyphicons glyphicons-folder-closed',
        'scissors'             => 'glyphicons glyphicons-scissors-alt',
        'folder-open'          => 'glyphicons glyphicons-folder-open',
        'credit-card'          => 'glyphicons glyphicons-credit-card',
        'eyedropper'           => 'glyphicons glyphicons-eyedropper',
        'fullscreen'           => 'glyphicons glyphicons-fullscreen',
        'paperclip'            => 'glyphicons glyphicons-paperclip',
        'translate'            => 'glyphicons glyphicons-translate',
        'duplicate'            => 'glyphicons glyphicons-duplicate',
        'airplane'             => 'glyphicons glyphicons-airplane',
        'comments'             => 'glyphicons glyphicons-comments',
        'picture'              => 'glyphicons glyphicons-picture',
        'retweet'              => 'glyphicons glyphicons-retweet',
        'global'               => 'glyphicons glyphicons-global',
        'server'               => 'glyphicons glyphicons-server',
        'globe'                => 'glyphicons glyphicons-globe',
        'brush'                => 'glyphicons glyphicons-brush',
        'redo'                 => 'glyphicons glyphicons-redo',
        'order'                => 'glyphicons glyphicons-sort',
        'link'                 => 'glyphicons glyphicons-link',
        'car'                  => 'glyphicons glyphicons-car',
        'external-link'        => 'fa fa-external-link',
        'video-camera'         => 'fa fa-video-camera',
        'file-image'           => 'fa fa-file-image-o',
        'cloud-upload'         => 'fa fa-cloud-upload',
        'newspaper'            => 'fa fa-newspaper-o',
        'rss-square'           => 'fa fa-rss-square',
        'map-marker'           => 'fa fa-map-marker',
        'power-off'            => 'fa fa-power-off',
        'dashboard'            => 'fa fa-dashboard',
        'compress'             => 'fa fa-compress',
        'language'             => 'fa fa-language',
        'list-alt'             => 'fa fa-list-alt',
        'arrows-h'             => 'fa fa-arrows-h',
        'arrows-v'             => 'fa fa-arrows-v',
        'envelope'             => 'fa fa-envelope',
        'sitemap'              => 'fa fa-sitemap',
        'options'              => 'fa fa-options',
        'refresh'              => 'fa fa-refresh',
        'warning'              => 'fa fa-warning',
        'repeat'               => 'fa fa-repeat',
        'laptop'               => 'fa fa-laptop',
        'upload'               => 'fa fa-upload',
        'search'               => 'fa fa-search',
        'pencil'               => 'fa fa-pencil',
        'expand'               => 'fa fa-expand',
        'phone'                => 'fa fa-phone',
        'users'                => 'fa fa-users',
        'trash'                => 'fa fa-trash',
        'check'                => 'fa fa-check',
        'film'                 => 'fa fa-film',
        'star'                 => 'fa fa-star',
        'code'                 => 'fa fa-code',
        'save'                 => 'fa fa-save',
        'bars'                 => 'fa fa-bars',
        'cog'                  => 'fa fa-cog',
        'rss'                  => 'fa fa-rss',
        'tag'                  => 'fa fa-tag'
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
