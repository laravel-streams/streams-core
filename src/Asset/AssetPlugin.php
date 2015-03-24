<?php namespace Anomaly\Streams\Platform\Asset;

use Anomaly\Streams\Platform\Addon\Plugin\Plugin;

/**
 * Class AssetPlugin
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Asset
 */
class AssetPlugin extends Plugin
{

    /**
     * The asset utility.
     *
     * @var Asset
     */
    protected $asset;

    /**
     * Create a new AssetPlugin instance.
     *
     * @param Asset $asset
     */
    public function __construct(Asset $asset)
    {
        $this->asset = $asset;
    }

    /**
     * Get functions.
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('asset_add', [$this->asset, 'add'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('asset_url', [$this->asset, 'url'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('asset_urls', [$this->asset, 'urls'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('asset_path', [$this->asset, 'path'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('asset_paths', [$this->asset, 'paths'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('asset_style', [$this->asset, 'style'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('asset_styles', [$this->asset, 'styles'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('asset_script', [$this->asset, 'script'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('asset_scripts', [$this->asset, 'scripts'], ['is_safe' => ['html']]),
        ];
    }
}
