<?php namespace Anomaly\Streams\Platform\Lang;

use Anomaly\Streams\Platform\Application\Application;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;

class Loader extends FileLoader
{

    /**
     * The application instance.
     *
     * @var Application
     */
    protected $application;

    /**
     * Create a new Loader instance.
     *
     * @param Filesystem $files
     * @param string     $path
     */
    public function __construct(Filesystem $files, $path)
    {
        $this->application = app(Application::class);

        parent::__construct($files, $path);
    }

    /**
     * Load namespaced overrides from
     * system AND application paths.
     *
     * @param  array  $lines
     * @param  string $locale
     * @param  string $group
     * @param  string $namespace
     * @return array
     */
    protected function loadNamespaceOverrides(array $lines, $locale, $group, $namespace)
    {
        $lines = $this->loadSystemOverrides($lines, $locale, $group, $namespace);
        $lines = $this->loadApplicationOverrides($lines, $locale, $group, $namespace);

        return parent::loadNamespaceOverrides($lines, $locale, $group, $namespace);
    }

    /**
     * Load system overrides.
     *
     * @param  array $lines
     * @param        $locale
     * @param        $group
     * @param        $namespace
     * @return array
     */
    protected function loadSystemOverrides(array $lines, $locale, $group, $namespace)
    {
        if ($namespace == 'streams') {
            $file = base_path("resources/streams/lang/{$locale}/{$group}.php");

            if ($this->files->exists($file)) {
                $lines = array_replace_recursive($lines, $this->files->getRequire($file));
            }
        }

        if (str_is('*.*.*', $namespace)) {
            list($vendor, $type, $slug) = explode('.', $namespace);

            $file = base_path("resources/addons/{$vendor}/{$slug}-{$type}/lang/{$locale}/{$group}.php");

            if ($this->files->exists($file)) {
                $lines = array_replace_recursive($lines, $this->files->getRequire($file));
            }
        }

        return $lines;
    }

    /**
     * Load system overrides.
     *
     * @param  array $lines
     * @param        $locale
     * @param        $group
     * @param        $namespace
     * @return array
     */
    protected function loadApplicationOverrides(array $lines, $locale, $group, $namespace)
    {
        if ($namespace == 'streams') {
            $file = $this->application->getResourcesPath("streams/lang/{$locale}/{$group}.php");

            if ($this->files->exists($file)) {
                $lines = array_replace_recursive($lines, $this->files->getRequire($file));
            }
        }

        if (str_is('*.*.*', $namespace)) {
            list($vendor, $type, $slug) = explode('.', $namespace);

            $file = $this->application->getResourcesPath(
                "addons/{$vendor}/{$slug}-{$type}/lang/{$locale}/{$group}.php"
            );

            if ($this->files->exists($file)) {
                $lines = array_replace_recursive($lines, $this->files->getRequire($file));
            }
        }

        return $lines;
    }
}
