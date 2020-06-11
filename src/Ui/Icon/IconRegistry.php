<?php

namespace Anomaly\Streams\Platform\Ui\Icon;

use Illuminate\Support\Arr;

/**
 * Class IconRegistry
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class IconRegistry
{

    /**
     * Available icon.
     *
     * @var array
     */
    protected $icons = [
        'addon'                => 'fas fa-puzzle-piece',
        'adjust'               => 'glyphicons glyphicons-adjust-alt',
        'airplane'             => 'glyphicons glyphicons-airplane',
        'amex'                 => 'fas fa-cc-amex',
        'arrows-h'             => 'fas fa-arrows-h',
        'arrows-v'             => 'fas fa-arrows-v',
        'ban'                  => 'fas fa-ban',
        'bars'                 => 'fas fa-bars',
        'bookmark'             => 'fas fa-bookmark',
        'bookmark-alt'         => 'fas fa-bookmark-o',
        'book-open'            => 'glyphicons glyphicons-book-open',
        'brush'                => 'glyphicons glyphicons-brush',
        'calendar'             => 'glyphicons glyphicons-calendar',
        'car'                  => 'glyphicons glyphicons-car',
        'check'                => 'fas fa-check',
        'check-circle'         => 'fas fa-check-circle',
        'check-circle-alt'     => 'fas fa-check-circle-o',
        'check-square-alt'     => 'fas fa-check-square-o',
        'circle'               => 'fas fa-circle',
        'circle-alt'           => 'fas fa-circle-o',
        'circle-question-mark' => 'glyphicons glyphicons-circle-question-mark',
        'cloud-plus'           => 'glyphicons glyphicons-cloud-plus',
        'cloud-upload'         => 'fas fa-cloud-upload',
        'cloud-upload-alt'     => 'glyphicons glyphicons-cloud-upload',
        'code'                 => 'fas fa-code',
        'code-fork'            => 'fas fa-code-fork',
        'cog'                  => 'fas fa-cog',
        'cogs'                 => 'fas fa-cogs',
        'comments'             => 'glyphicons glyphicons-comments',
        'compress'             => 'fas fa-compress',
        'conversation'         => 'glyphicons glyphicons-conversation',
        'credit-card'          => 'glyphicons glyphicons-credit-card',
        'cubes'                => 'fas fa-cubes',
        'dashboard'            => 'fas fa-dashboard',
        'database'             => 'fas fa-database',
        'diners-club'          => 'fa  fa-cc-diners-club',
        'discover'             => 'fas fa-cc-discover',
        'download'             => 'fas fa-download',
        'duplicate'            => 'glyphicons glyphicons-duplicate',
        'envelope'             => 'fas fa-envelope',
        'envelope-alt'         => 'fas fa-envelope-o',
        'exchange'             => 'fas fa-exchange',
        'exit'                 => 'fas fa-sign-out',
        'expand'               => 'fas fa-expand',
        'external-link'        => 'fas fa-external-link',
        'eyedropper'           => 'glyphicons glyphicons-eyedropper',
        'facebook'             => 'fas fa-facebook',
        'facebook-square'      => 'fas fa-facebook-square',
        'facetime-video'       => 'glyphicons glyphicons-facetime-video',
        'file'                 => 'fas fa-file-o',
        'file-image'           => 'fas fa-file-image-o',
        'film'                 => 'fas fa-film',
        'filter'               => 'fas fa-filter',
        'fire'                 => 'glyphicons glyphicons-fire',
        'flag'                 => 'fas fa-flag',
        'folder-closed'        => 'glyphicons glyphicons-folder-closed',
        'folder-open'          => 'glyphicons glyphicons-folder-open',
        'fullscreen'           => 'glyphicons glyphicons-fullscreen',
        'git-branch'           => 'glyphicons glyphicons-git-branch',
        'global'               => 'glyphicons glyphicons-global',
        'globe'                => 'glyphicons glyphicons-globe',
        'history'              => 'fas fa-history',
        'home'                 => 'fas fa-home',
        'jcb'                  => 'fas fa-cc-jcb',
        'keys'                 => 'glyphicons glyphicons-keys',
        'language'             => 'fas fa-language',
        'laptop'               => 'fas fa-laptop',
        'link'                 => 'glyphicons glyphicons-link',
        'list-alt'             => 'fas fa-list-alt',
        'list-ol'              => 'fas fa-list-ol',
        'list-ul'              => 'fas fa-list-ul',
        'lock'                 => 'fas fa-lock',
        'locked'               => 'fas fa-lock',
        'magic'                => 'glyphicons glyphicons-magic',
        'map-marker'           => 'fas fa-map-marker',
        'mastercard'           => 'fas fa-cc-mastercard',
        'minus'                => 'fas fa-minus',
        'newspaper'            => 'fas fa-newspaper-o',
        'options'              => 'fas fa-options',
        'order'                => 'glyphicons glyphicons-sort',
        'paperclip'            => 'glyphicons glyphicons-paperclip',
        'paypal'               => 'fas fa-cc-paypal',
        'pencil'               => 'fas fa-pencil-alt',
        'percent'              => 'fas fa-percent',
        'phone'                => 'fas fa-phone',
        'picture'              => 'glyphicons glyphicons-picture',
        'play'                 => 'fas fa-play',
        'plug'                 => 'fas fa-plug',
        'plus'                 => 'fas fa-plus',
        'plus-circle'          => 'fas fa-plus-circle',
        'plus-square'          => 'fas fa-plus-square',
        'power-off'            => 'fas fa-power-off',
        'question'             => 'fas fa-question',
        'question-circle'      => 'fas fa-question-circle',
        'quote-left'           => 'fas fa-quote-left',
        'quote-right'          => 'fas fa-quote-right',
        'redo'                 => 'glyphicons glyphicons-redo',
        'refresh'              => 'fas fa-refresh',
        'repeat'               => 'fas fa-repeat',
        'retweet'              => 'glyphicons glyphicons-retweet',
        'rss'                  => 'fas fa-rss',
        'rss-square'           => 'fas fa-rss-square',
        'save'                 => 'fas fa-save',
        'scissors'             => 'glyphicons glyphicons-scissors-alt',
        'search'               => 'fas fa-search',
        'server'               => 'glyphicons glyphicons-server',
        'share'                => 'fas fa-share-alt',
        'shopping-cart'        => 'glyphicons glyphicons-shopping-cart',
        'sign-in'              => 'fas fa-sign-in',
        'sign-out'             => 'fas fa-sign-out',
        'sitemap'              => 'fas fa-sitemap',
        'sliders'              => 'fas fa-sliders',
        'sort-ascending'       => 'fas fa-sort-amount-down-alt',
        'sort-descending'      => 'fas fa-sort-amount-down',
        'sortable'             => 'fas fa-sort',
        'square'               => 'fas fa-square',
        'square-alt'           => 'fas fa-square-o',
        'star'                 => 'fas fa-star',
        'stripe'               => 'fa-cc-stripe',
        'tag'                  => 'fas fa-tag',
        'tags'                 => 'fas fa-tags',
        'th'                   => 'fas fa-th',
        'th-large'             => 'fas fa-th-large',
        'thumbnails'           => 'glyphicons glyphicons-thumbnails',
        'times'                => 'fas fa-times',
        'times-circle'         => 'fas fa-times-circle',
        'times-square'         => 'fas fa-times-square',
        'translate'            => 'glyphicons glyphicons-translate',
        'trash'                => 'fas fa-trash',
        'truck'                => 'fas fa-truck',
        'twitter'              => 'fas fa-twitter',
        'unlock'               => 'fas fa-unlock',
        'upload'               => 'fas fa-upload',
        'usd'                  => 'fas fa-usd',
        'user'                 => 'fas fa-user',
        'users'                => 'fas fa-users',
        'video-camera'         => 'fas fa-video-camera',
        'warning'              => 'fas fa-warning',
        'wrench'               => 'fas fa-wrench',
        'youtube'              => 'fas fa-youtube',
    ];

    /**
     * Get an icon.
     *
     * @param  $icon
     * @return string
     */
    public function get($icon)
    {
        return Arr::get($this->icons, $icon, $icon);
    }

    /**
     * Register an icon.
     *
     * @param        $icon
     * @param  array $class
     * @return $this
     */
    public function register($icon, array $class)
    {
        Arr::set($this->icons, $icon, $class);

        return $this;
    }

    /**
     * Get the icons.
     *
     * @return array
     */
    public function getIcons()
    {
        return $this->icons;
    }

    /**
     * Set the icons.
     *
     * @param array $icons
     * @return $this
     */
    public function setIcons(array $icons)
    {
        $this->icons = $icons;

        return $this;
    }
}
