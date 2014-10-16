<?php namespace Streams\Platform\Asset;

use Assetic\Asset\GlobAsset;
use Assetic\Asset\FileAsset;
use Assetic\Asset\AssetCollection;
use Streams\Platform\Asset\Filter\JSMinFilter;
use Streams\Platform\Asset\Filter\CssMinFilter;
use Streams\Platform\Asset\Filter\LessphpFilter;
use Streams\Platform\Asset\Filter\ScssphpFilter;
use Streams\Platform\Asset\Filter\CoffeePhpFilter;
use Streams\Platform\Asset\Filter\PhpCssEmbedFilter;

class Asset
{
    protected $directory = null;

    protected $publish = false;

    protected $namespaces = [];

    protected $groups = [];

    public function add($group, $asset, array $filters = [])
    {
        if (!isset($this->groups[$group])) {
            $this->groups[$group] = [];
        }

        $filters = $this->addConvenientFilters($asset, $filters);

        $asset = $this->replaceNamespace($asset);

        if (file_exists($asset) or is_dir(trim($asset, '*'))) {
            $this->groups[$group][$asset] = $filters;
        }

        return $this;
    }

    public function path($group, array $filters = [])
    {
        if (!isset($this->groups[$group])) {
            $this->add($group, $group, $filters);
        }

        return $this->getPath($group, $filters);
    }

    public function paths($group, array $additionalFilters = [])
    {
        return array_filter(
            array_map(
                function ($asset, $filters) use ($additionalFilters) {

                    $filters = array_filter(array_unique(array_merge($filters, $additionalFilters)));

                    return $this->path($asset, $filters);
                },
                array_keys($this->groups[$group]),
                array_values($this->groups[$group])
            )
        );
    }

    protected function getPath($group, $filters)
    {
        $hash = hashify($this->groups[$group]);

        $hint = $this->getHint($group);

        $path = 'assets/' . APP_REF . '/' . $hash . '.' . $hint;

        if (isset($_GET['_publish']) or $this->publish) {
            $this->publish($path, $group, $filters);
        }

        return $path;
    }

    protected function publish($path, $group, $additionalFilters)
    {
        $collection = new AssetCollection();

        $hint = $this->getHint($group);

        foreach ($this->groups[$group] as $asset => $filters) {

            $filters = array_filter(array_unique(array_merge($filters, $additionalFilters)));

            $filters = $this->transformFilters($filters, $hint);

            if (ends_with($asset, '*')) {
                $asset = new GlobAsset($asset, $filters);
            } else {
                $asset = new FileAsset($asset, $filters);
            }

            $collection->add($asset);

        }

        $path = $this->directory . $path;

        $files = app('files');

        $files->makeDirectory((new \SplFileInfo($path))->getPath(), 777, true, true);

        $files->put($path, $collection->dump());
    }

    protected function transformFilters($filters, $hint)
    {
        foreach ($filters as &$filter) {

            switch ($filter) {
                case 'less':
                    $filter = new LessphpFilter();
                    break;

                case 'scss':
                    $filter = new ScssphpFilter();
                    break;

                case 'coffee':
                    $filter = new CoffeePhpFilter();
                    break;

                case 'embed':
                    $filter = new PhpCssEmbedFilter();
                    break;

                case 'min':
                    if ($hint == 'js') {
                        $filter = new JSMinFilter();
                    } elseif ($hint == 'css') {
                        $filter = new CssMinFilter();
                    }
                    break;
            }

        }

        return $filters;
    }

    protected function addConvenientFilters($asset, $filters)
    {
        if (ends_with($asset, '.less')) {
            $filters[] = 'less';
        }

        if (ends_with($asset, '.scss')) {
            $filters[] = 'scss';
        }

        if (ends_with($asset, '.coffee')) {
            $filters[] = 'coffee';
        }

        return array_unique($filters);
    }

    protected function getExtension($path)
    {
        return pathinfo($path, PATHINFO_EXTENSION);
    }

    protected function getHint($path)
    {
        $hint = $this->getExtension($path);

        if ($hint == 'less') {
            $hint = 'css';
        }

        if ($hint == 'coffee') {
            $hint = 'js';
        }

        return $hint;
    }

    protected function replaceNamespace($path)
    {
        if (str_contains($path, '::')) {

            list ($namespace, $path) = explode('::', $path);

            if (isset($this->namespaces[$namespace]) and $location = $this->namespaces[$namespace]) {
                $path = $location . '/' . $path;
            }

        }

        return $path;
    }

    public function addNamespace($binding, $path)
    {
        $this->namespaces[$binding] = $path;

        return $this;
    }

    public function setDirectory($directory)
    {
        $this->directory = $directory;

        return $this;
    }

    public function setPublish($publish)
    {
        $this->publish = $publish;

        return $this;
    }
}
