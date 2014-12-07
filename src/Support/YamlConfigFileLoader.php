<?php namespace Anomaly\Streams\Platform\Support;

use Illuminate\Config\FileLoader;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Yaml\Parser;

/**
 * Class YamlConfigFileLoader
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Support
 */
class YamlConfigFileLoader extends FileLoader
{

    /**
     * @var \Symfony\Component\Yaml\Parser
     */
    protected $parser;

    /**
     * @param Filesystem $files
     * @param Parser     $parser
     * @param            $defaultPath
     */
    public function __construct(Filesystem $files, Parser $parser, $defaultPath)
    {
        $this->parser = $parser;

        parent::__construct($files, $defaultPath);
    }

    /**
     * @return array
     */
    protected function getAllowedFileExtensions()
    {
        return ['php', 'yml', 'yaml'];
    }

    /**
     * @param string $environment
     * @param string $group
     * @param null   $namespace
     * @return array
     */
    public function load($environment, $group, $namespace = null)
    {
        $items = [];

        $path = $this->getPath($namespace);

        if (is_null($path)) {

            return $items;
        }

        foreach ($this->getAllowedFileExtensions() as $extension) {

            $file = "{$path}/{$group}." . $extension;

            if ($this->files->exists($file)) {

                $items = $this->mergeEnvironmentWithYamlSupport($items, $file, $extension);
            }

            $file = "{$path}/{$environment}/{$group}." . $extension;

            if ($this->files->exists($file)) {

                $items = $this->mergeEnvironmentWithYamlSupport($items, $file, $extension);
            }
        }

        return $items;
    }

    /**
     * @param array $items
     * @param       $file
     * @param       $extension
     * @return array
     */
    protected function mergeEnvironmentWithYamlSupport(array $items, $file, $extension)
    {
        return array_replace_recursive($items, $this->parseContent($extension, $file));
    }

    /**
     * @param string $group
     * @param null   $namespace
     * @return bool
     */
    public function exists($group, $namespace = null)
    {
        $key = $group . $namespace;

        if (isset($this->exists[$key])) {

            return $this->exists[$key];
        }

        $path = $this->getPath($namespace);

        if (is_null($path)) {

            return $this->exists[$key] = false;
        }

        foreach ($this->getAllowedFileExtensions() as $extension) {

            $file = "{$path}/{$group}." . $extension;

            if ($exists = $this->files->exists($file)) {

                return $this->exists[$key] = $exists;
            }
        }

        return $this->exists[$key] = false;
    }

    /**
     * @param string $env
     * @param string $package
     * @param string $group
     * @param array  $items
     * @return array
     */
    public function cascadePackage($env, $package, $group, $items)
    {
        foreach ($this->getAllowedFileExtensions() as $extension) {

            $file = "packages/{$package}/{$group}." . $extension;

            if ($this->files->exists($path = $this->defaultPath . '/' . $file)) {

                $items = array_merge($items, $this->parseContent($extension, $path));
            }

            $path = $this->getPackagePath($env, $package, $group, $extension);

            if ($this->files->exists($path)) {

                $items = array_merge($items, $this->parseContent($extension, $path));
            }
        }

        return $items;
    }

    /**
     * @param string $env
     * @param string $package
     * @param string $group
     * @param string $extension
     * @return string
     */
    protected function getPackagePath($env, $package, $group, $extension = 'php')
    {
        $file   = "packages/{$package}/{$env}/{$group}." . $extension;
        $result = $this->defaultPath . '/' . $file;

        return $result;
    }

    /**
     * @param $format
     * @param $file
     * @return array|mixed|null
     */
    protected function parseContent($format, $file)
    {
        $content = null;

        switch ($format) {

            case 'php':
                $content = $this->files->getRequire($file);
                break;

            case 'yml':

            case 'yaml':
                $content = $this->parser->parse(file_get_contents($file));
                break;
        }

        return $content;
    }
}
 