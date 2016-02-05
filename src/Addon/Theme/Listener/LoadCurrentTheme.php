<?php namespace Anomaly\Streams\Platform\Addon\Theme\Listener;

use Anomaly\Streams\Platform\Addon\Theme\ThemeCollection;
use Anomaly\Streams\Platform\Asset\Asset;
use Anomaly\Streams\Platform\Image\Image;
use Illuminate\Config\Repository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Translation\Translator;

/**
 * Class LoadCurrentTheme
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Listener
 */
class LoadCurrentTheme
{

    /**
     * The view factory.
     *
     * @var Factory
     */
    protected $view;

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
     * The translator utility.
     *
     * @var Translator
     */
    private $translator;

    /**
     * Create a new LoadCurrentTheme instance.
     *
     * @param Asset           $asset
     * @param Image           $image
     * @param Factory         $view
     * @param Request         $request
     * @param Repository      $config
     * @param ThemeCollection $themes
     * @param Translator      $translator
     */
    public function __construct(
        Asset $asset,
        Image $image,
        Factory $view,
        Request $request,
        Repository $config,
        ThemeCollection $themes,
        Translator $translator
    ) {
        $this->view       = $view;
        $this->asset      = $asset;
        $this->image      = $image;
        $this->themes     = $themes;
        $this->config     = $config;
        $this->request    = $request;
        $this->translator = $translator;
    }

    /**
     * Detect the active theme and set up
     * our environment with it.
     */
    public function handle()
    {
        $admin    = $this->themes->get($this->config->get('streams::themes.admin'));
        $standard = $this->themes->get($this->config->get('streams::themes.standard'));

        if ($admin && in_array($this->request->segment(1), ['installer', 'admin'])) {
            $admin->setActive(true);
            $admin->setCurrent(true);
        } elseif ($standard) {
            $standard->setActive(true);
            $standard->setCurrent(true);
        }

        if ($theme = $this->themes->current()) {

            $this->view->addNamespace('theme', $theme->getPath('resources/views'));
            $this->translator->addNamespace('theme', $theme->getPath('resources/lang'));

            $this->asset->addPath('theme', $theme->getPath('resources'));
            $this->image->addPath('theme', $theme->getPath('resources'));
        }
    }
}
