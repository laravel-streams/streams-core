<?php

namespace Anomaly\Streams\Platform\View\Twig;

use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Addon\Module\Module;
use Anomaly\Streams\Platform\Addon\Theme\Theme;
use Anomaly\Streams\Platform\View\ViewMobileOverrides;
use Anomaly\Streams\Platform\View\ViewOverrides;
use Illuminate\Console\Application;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\View\Factory;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\View\ViewFinderInterface;
use Mobile_Detect;

/**
 * Basic loader using absolute paths.
 */
class Loader extends OriginalLoader
{

    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * @var \Illuminate\View\ViewFinderInterface
     */
    protected $finder;

    /**
     * @var string Twig file extension.
     */
    protected $extension;

    /**
     * @var array Template lookup cache.
     */
    protected $cache = [];

    /**
     * The view factory.
     *
     * @var Factory
     */
    protected $view;

    /**
     * The agent utility.
     *
     * @var Mobile_Detect
     */
    protected $agent;

    /**
     * The event dispatcher.
     *
     * @var Dispatcher
     */
    protected $events;

    /**
     * The current theme.
     *
     * @var Theme|null
     */
    protected $theme;

    /**
     * The active module.
     *
     * @var Module|null
     */
    protected $module;

    /**
     * The addon collection.
     *
     * @var AddonCollection
     */
    protected $addons;

    /**
     * The request object.
     *
     * @var Request
     */
    protected $request;

    /**
     * The view overrides collection.
     *
     * @var ViewOverrides
     */
    protected $overrides;

    /**
     * The application instance.
     *
     * @var Application
     */
    protected $application;

    /**
     * The view mobile overrides.
     *
     * @var ViewMobileOverrides
     */
    protected $mobiles;

    protected $mobile;

    /**
     * Loader constructor.
     *
     * @param Filesystem $files
     * @param ViewFinderInterface $finder
     * @param string $extension
     * @param Factory $view
     * @param Mobile_Detect $agent
     * @param Dispatcher $events
     * @param AddonCollection $addons
     * @param ViewOverrides $overrides
     * @param Request $request
     * @param ViewMobileOverrides $mobiles
     */
    public function __construct(
        Filesystem $files,
        ViewFinderInterface $finder,
        $extension = 'twig',
        Factory $view,
        Mobile_Detect $agent,
        Dispatcher $events,
        AddonCollection $addons,
        ViewOverrides $overrides,
        Request $request,
        ViewMobileOverrides $mobiles
    ) {
        $this->view      = $view;
        $this->agent     = $agent;
        $this->events    = $events;
        $this->addons    = $addons;
        $this->mobiles   = $mobiles;
        $this->request   = $request;
        $this->overrides = $overrides;

        $area = $request->segment(1) == 'admin' ?: 'standard';

        $this->theme  = $this->addons->themes->active($area);
        $this->module = $this->addons->modules->active();

        $this->mobile = $this->agent->isMobile();

        parent::__construct($files, $finder, $extension);
    }

    /**
     * Gets the path.
     *
     * @param      string   $name   The name
     * @return     boolean  The path.
     */
    protected function getPath($name)
    {
        $mobile = $this->mobiles->get($this->theme->getNamespace(), []);
        $result = false;

        /**
         * Merge system configured overrides
         * with the overrides from the addon.
         */
        $overrides = array_merge(
            $this->overrides->get($this->theme->getNamespace(), []),
            config('streams.overrides', [])
        );

        $name = str_replace('theme::', $this->theme->getNamespace() . '::', $name);

        if ($this->mobile && $path = array_get($mobile, $name)) {
            $result = $path;
        } elseif ($path = array_get($overrides, $name)) {
            $result = $path;
        }

        if ($this->module) {
            $mobile    = $this->mobiles->get($this->module->getNamespace(), []);
            $overrides = $this->overrides->get($this->module->getNamespace(), []);

            if ($this->mobile && $path = array_get($mobile, $name)) {
                $result = $path;
            } elseif ($path = array_get($overrides, $name)) {
                $result = $path;
            } elseif ($path = array_get(config('streams.overrides'), $name)) {
                $result = $path;
            }
        }

        if ($path = $this->getOverloadPath($name)) {
            return $path;
        }

        return $result;
    }

    /**
     * Gets the overload path.
     *
     * @param      string  $name   The name
     * @return     string  The overload path.
     */
    protected function getOverloadPath($name)
    {
        /*
         * We can only overload namespaced
         * views right now.
         */
        if (!str_contains($name, '::')) {
            return null;
        }

        /*
         * Split the view into it's
         * namespace and path.
         */
        list($namespace, $path) = explode('::', $name);

        $override = null;
        $path     = str_replace('.', '/', $path);

        /*
         * If the view is a streams view then
         * it's real easy to guess what the
         * override path should be.
         */
        if ($namespace == 'streams') {
            $path = $this->theme->getNamespace("streams/{$path}");
        }

        /*
         * If the view uses a dot syntax namespace then
         * transform it all into the override view path.
         */
        if ($addon = $this->addons->get($namespace)) {
            $override = $this->theme->getNamespace(
                "addons/{$addon->getVendor()}/{$addon->getSlug()}-{$addon->getType()}/{$path}"
            );
        }

        if ($this->view->exists($override)) {
            return $override;
        }

        return null;
    }

    /**
     * Return path to template without the need for the extension.
     *
     * @param string $name Template file name or path.
     * @throws \Twig_Error_Loader
     * @return string Path to template
     */
    public function findTemplate($name)
    {
        if ($this->files->exists($name)) {
            return $name;
        }

        $name = $this->normalizeName($name);

        if ($cached = array_get($this->cache, $name)) {
            return $cached;
        }

        $file = $name;

        if ($path = $this->getPath($name)) {
            $file = $path;
        }

        try {
            $this->cache[$name] = $this->finder->find($file);
        } catch (\InvalidArgumentException $e) {
            throw new \Twig_Error_Loader($e->getMessage());
        }

        return array_get($this->cache, $name);
    }

}
