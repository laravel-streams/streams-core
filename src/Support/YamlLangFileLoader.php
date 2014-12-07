<?php namespace Anomaly\Streams\Platform\Support;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Symfony\Component\Yaml\Parser;

/**
 * Class YamlLangFileLoader
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Support
 */
class YamlLangFileLoader extends FileLoader
{

    /**
     * The YAML parser instance
     *
     * @var \Symfony\Component\Yaml\Parser
     */
    protected $parser;

    /**
     * Create a new YamlLangFileLoader instance.
     *
     * @param Filesystem $files
     * @param Parser     $parser
     * @param            $path
     */
    public function __construct(Filesystem $files, Parser $parser, $path)
    {
        $this->path   = $path;
        $this->files  = $files;
        $this->parser = $parser;
    }

    /**
     * Load namespace overrides.
     *
     * @param array  $lines
     * @param string $locale
     * @param string $group
     * @param string $namespace
     * @return array
     */
    protected function loadNamespaceOverrides(array $lines, $locale, $group, $namespace)
    {
        $file = "{$this->path}/packages/{$locale}/{$namespace}/{$group}.yml";

        if ($this->files->exists($file)) {

            return array_replace_recursive($lines, $this->loadYaml($file));
        }

        // Fallback to PHP version if no YAML file exists.
        return parent::loadNamespaceOverrides($lines, $locale, $group, $namespace);
    }

    /**
     * Load path.
     *
     * @param string $path
     * @param string $locale
     * @param string $group
     * @return array
     */
    protected function loadPath($path, $locale, $group)
    {
        if ($this->files->exists($full = "{$path}/{$locale}/{$group}.yml")) {

            return $this->loadYaml($full);
        }

        // Fallback to PHP version if no YAML file exists.
        return parent::loadPath($path, $locale, $group);
    }

    /**
     * Load the YAML content
     *
     * @param string $path
     * @return array
     */
    protected function loadYaml($path)
    {
        return (array)$this->parser->parse($this->files->get($path));
    }
}