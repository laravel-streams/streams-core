<?php namespace Anomaly\Streams\Platform\Addon\Theme\Listener;

use Anomaly\Streams\Platform\Addon\Theme\Theme;
use Anomaly\Streams\Platform\Addon\Theme\ThemeCollection;
use Anomaly\Streams\Platform\Asset\Asset;
use Anomaly\Streams\Platform\Image\Image;
use Illuminate\Config\Repository;
use Illuminate\Http\Request;

/**
 * Class LoadActiveTheme
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Listener
 */
class LoadActiveTheme
{

    /**
     * The asset utility.
     *
     * @var Asset
     */
    protected $asset;

    /**
     * The image utility.
     *
     * @var Image
     */
    protected $image;

    /**
     * The theme collection.
     *
     * @var ThemeCollection
     */
    protected $themes;

    /**
     * The config repository.
     *
     * @var Repository
     */
    protected $config;

    /**
     * The request object.
     *
     * @var Request
     */
    protected $request;

    /**
     * Create a new LoadActiveTheme instance.
     *
     * @param Asset      $asset
     * @param Image      $image
     * @param Request    $request
     * @param Repository $config
     */
    public function __construct(
        Asset $asset,
        Image $image,
        Request $request,
        Repository $config,
        ThemeCollection $themes
    ) {
        $this->asset   = $asset;
        $this->image   = $image;
        $this->themes  = $themes;
        $this->config  = $config;
        $this->request = $request;
    }

    /**
     * Detect the active theme and set up
     * our environment with it.
     */
    public function handle()
    {
        if (in_array($this->request->segment(1), ['installer', 'admin'])) {
            $theme = $this->themes->admin()->active();
        } else {
            $theme = $this->themes->standard()->active();
        }

        if (!$theme instanceof Theme && $this->request->segment(1) === 'admin') {
            $theme = $this->themes->get($this->config->get('streams::themes.active.admin'));
        } else {
            $theme = $this->themes->get($this->config->get('streams::themes.active.standard'));
        }

        if ($theme instanceof Theme) {

            $theme->setActive(true);
            $theme->setCurrent(true);

            app('view')->addNamespace('theme', $theme->getPath('resources/views'));
            app('translator')->addNamespace('theme', $theme->getPath('resources/lang'));

            $this->asset->addPath('theme', $theme->getPath('resources'));
            $this->image->addPath('theme', $theme->getPath('resources'));
        }
    }
}
