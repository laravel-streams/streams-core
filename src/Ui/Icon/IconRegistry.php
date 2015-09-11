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
     * Available icon.
     *
     * @var array
     */
    protected $icons = [
        'circle-question-mark' => 'glyphicons glyphicons-circle-question-mark',
        'sort-descending'      => 'glyphicons glyphicons-sort-by-attributes-alt',
        'sort-ascending'       => 'glyphicons glyphicons-sort-by-attributes',
        'facetime-video'       => 'glyphicons glyphicons-facetime-video',
        'shopping-cart'        => 'glyphicons glyphicons-shopping-cart',
        'folder-closed'        => 'glyphicons glyphicons-folder-closed',
        'cloud-upload-alt'     => 'glyphicons glyphicons-cloud-upload',
        'scissors'             => 'glyphicons glyphicons-scissors-alt',
        'conversation'         => 'glyphicons glyphicons-conversation',
        'folder-open'          => 'glyphicons glyphicons-folder-open',
        'credit-card'          => 'glyphicons glyphicons-credit-card',
        'cloud-plus'           => 'glyphicons glyphicons-cloud-plus',
        'adjust'               => 'glyphicons glyphicons-adjust-alt',
        'eyedropper'           => 'glyphicons glyphicons-eyedropper',
        'fullscreen'           => 'glyphicons glyphicons-fullscreen',
        'paperclip'            => 'glyphicons glyphicons-paperclip',
        'translate'            => 'glyphicons glyphicons-translate',
        'duplicate'            => 'glyphicons glyphicons-duplicate',
        'airplane'             => 'glyphicons glyphicons-airplane',
        'calendar'             => 'glyphicons glyphicons-calendar',
        'comments'             => 'glyphicons glyphicons-comments',
        'picture'              => 'glyphicons glyphicons-picture',
        'retweet'              => 'glyphicons glyphicons-retweet',
        'sortable'             => 'glyphicons glyphicons-sorting',
        'global'               => 'glyphicons glyphicons-global',
        'server'               => 'glyphicons glyphicons-server',
        'magic'                => 'glyphicons glyphicons-magic',
        'globe'                => 'glyphicons glyphicons-globe',
        'brush'                => 'glyphicons glyphicons-brush',
        'redo'                 => 'glyphicons glyphicons-redo',
        'order'                => 'glyphicons glyphicons-sort',
        'link'                 => 'glyphicons glyphicons-link',
        'fire'                 => 'glyphicons glyphicons-fire',
        'keys'                 => 'glyphicons glyphicons-keys',
        'car'                  => 'glyphicons glyphicons-car',
        'check-circle-alt'     => 'fa fa-check-circle-o',
        'external-link'        => 'fa fa-external-link',
        'check-circle'         => 'fa fa-check-circle',
        'video-camera'         => 'fa fa-video-camera',
        'file-image'           => 'fa fa-file-image-o',
        'cloud-upload'         => 'fa fa-cloud-upload',
        'times-circle'         => 'fa fa-times-circle',
        'times-square'         => 'fa fa-times-square',
        'addon'                => 'fa fa-puzzle-piece',
        'newspaper'            => 'fa fa-newspaper-o',
        'plus-circle'          => 'fa fa-plus-circle',
        'plus-square'          => 'fa fa-plus-square',
        'rss-square'           => 'fa fa-rss-square',
        'map-marker'           => 'fa fa-map-marker',
        'power-off'            => 'fa fa-power-off',
        'dashboard'            => 'fa fa-dashboard',
        'compress'             => 'fa fa-compress',
        'language'             => 'fa fa-language',
        'database'             => 'fa fa-database',
        'list-alt'             => 'fa fa-list-alt',
        'arrows-h'             => 'fa fa-arrows-h',
        'arrows-v'             => 'fa fa-arrows-v',
        'envelope'             => 'fa fa-envelope',
        'facebook'             => 'fa fa-facebook',
        'twitter'              => 'fa fa-twitter',
        'sitemap'              => 'fa fa-sitemap',
        'options'              => 'fa fa-options',
        'refresh'              => 'fa fa-refresh',
        'warning'              => 'fa fa-warning',
        'unlock'               => 'fa fa-unlock',
        'filter'               => 'fa fa-filter',
        'repeat'               => 'fa fa-repeat',
        'laptop'               => 'fa fa-laptop',
        'upload'               => 'fa fa-upload',
        'search'               => 'fa fa-search',
        'pencil'               => 'fa fa-pencil',
        'expand'               => 'fa fa-expand',
        'file'                 => 'fa fa-file-o',
        'phone'                => 'fa fa-phone',
        'users'                => 'fa fa-users',
        'times'                => 'fa fa-times',
        'trash'                => 'fa fa-trash',
        'check'                => 'fa fa-check',
        'cubes'                => 'fa fa-cubes',
        'locked'               => 'fa fa-lock',
        'lock'                 => 'fa fa-lock',
        'film'                 => 'fa fa-film',
        'star'                 => 'fa fa-star',
        'code'                 => 'fa fa-code',
        'save'                 => 'fa fa-save',
        'play'                 => 'fa fa-play',
        'plus'                 => 'fa fa-plus',
        'bars'                 => 'fa fa-bars',
        'cogs'                 => 'fa fa-cogs',
        'cog'                  => 'fa fa-cog',
        'rss'                  => 'fa fa-rss',
        'tag'                  => 'fa fa-tag',
        'ban'                  => 'fa fa-ban'
    ];

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
