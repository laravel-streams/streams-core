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
        'git-branch'           => 'glyphicons glyphicons-git-branch',
        'cloud-plus'           => 'glyphicons glyphicons-cloud-plus',
        'adjust'               => 'glyphicons glyphicons-adjust-alt',
        'eyedropper'           => 'glyphicons glyphicons-eyedropper',
        'fullscreen'           => 'glyphicons glyphicons-fullscreen',
        'thumbnails'           => 'glyphicons glyphicons-thumbnails',
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
        'diners-club'          => 'fa  fa-cc-diners-club',
        'question-circle'      => 'fa fa-question-circle',
        'facebook-square'      => 'fa fa-facebook-square',
        'check-circle-alt'     => 'fa fa-check-circle-o',
        'check-square-alt'     => 'fa fa-check-square-o',
        'mastercard'           => 'fa fa-cc-mastercard',
        'external-link'        => 'fa fa-external-link',
        'check-circle'         => 'fa fa-check-circle',
        'video-camera'         => 'fa fa-video-camera',
        'file-image'           => 'fa fa-file-image-o',
        'cloud-upload'         => 'fa fa-cloud-upload',
        'times-circle'         => 'fa fa-times-circle',
        'times-square'         => 'fa fa-times-square',
        'addon'                => 'fa fa-puzzle-piece',
        'discover'             => 'fa fa-cc-discover',
        'newspaper'            => 'fa fa-newspaper-o',
        'plus-circle'          => 'fa fa-plus-circle',
        'plus-square'          => 'fa fa-plus-square',
        'quote-right'          => 'fa fa-quote-right',
        'quote-left'           => 'fa fa-quote-left',
        'rss-square'           => 'fa fa-rss-square',
        'map-marker'           => 'fa fa-map-marker',
        'paypal'               => 'fa fa-cc-paypal',
        'power-off'            => 'fa fa-power-off',
        'dashboard'            => 'fa fa-dashboard',
        'square-alt'           => 'fa fa-square-o',
        'circle-alt'           => 'fa fa-circle-o',
        'compress'             => 'fa fa-compress',
        'exchange'             => 'fa fa-exchange',
        'download'             => 'fa fa-download',
        'language'             => 'fa fa-language',
        'database'             => 'fa fa-database',
        'list-alt'             => 'fa fa-list-alt',
        'arrows-h'             => 'fa fa-arrows-h',
        'arrows-v'             => 'fa fa-arrows-v',
        'envelope'             => 'fa fa-envelope',
        'question'             => 'fa fa-question',
        'facebook'             => 'fa fa-facebook',
        'youtube'              => 'fa fa-youtube',
        'list-ol'              => 'fa fa-list-ol',
        'twitter'              => 'fa fa-twitter',
        'amex'                 => 'fa fa-cc-amex',
        'sitemap'              => 'fa fa-sitemap',
        'options'              => 'fa fa-options',
        'refresh'              => 'fa fa-refresh',
        'warning'              => 'fa fa-warning',
        'square'               => 'fa fa-square',
        'circle'               => 'fa fa-circle',
        'unlock'               => 'fa fa-unlock',
        'filter'               => 'fa fa-filter',
        'repeat'               => 'fa fa-repeat',
        'laptop'               => 'fa fa-laptop',
        'upload'               => 'fa fa-upload',
        'search'               => 'fa fa-search',
        'pencil'               => 'fa fa-pencil',
        'expand'               => 'fa fa-expand',
        'wrench'               => 'fa fa-wrench',
        'file'                 => 'fa fa-file-o',
        'jcb'                  => 'fa fa-cc-jcb',
        'stripe'               => 'fa-cc-stripe',
        'phone'                => 'fa fa-phone',
        'users'                => 'fa fa-users',
        'times'                => 'fa fa-times',
        'trash'                => 'fa fa-trash',
        'check'                => 'fa fa-check',
        'cubes'                => 'fa fa-cubes',
        'locked'               => 'fa fa-lock',
        'lock'                 => 'fa fa-lock',
        'home'                 => 'fa fa-home',
        'film'                 => 'fa fa-film',
        'star'                 => 'fa fa-star',
        'plug'                 => 'fa fa-plug',
        'code'                 => 'fa fa-code',
        'save'                 => 'fa fa-save',
        'play'                 => 'fa fa-play',
        'plus'                 => 'fa fa-plus',
        'bars'                 => 'fa fa-bars',
        'cogs'                 => 'fa fa-cogs',
        'tags'                 => 'fa fa-tags',
        'cog'                  => 'fa fa-cog',
        'rss'                  => 'fa fa-rss',
        'tag'                  => 'fa fa-tag',
        'ban'                  => 'fa fa-ban'
    ];

    /**
     * Get a button.
     *
     * @param  $icon
     * @return string
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
