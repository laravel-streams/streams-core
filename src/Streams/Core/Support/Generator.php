<?php namespace Streams\Core\Support;

use Illuminate\Filesystem\Filesystem as File;

class Generator
{
    /**
     * File path to generate.
     *
     * @var string
     */
    protected $path = null;

    /**
     * File system instance.
     *
     * @var File
     */
    protected $file = null;

    /**
     * The template file name.
     *
     * @var Cache
     */
    protected $templateFilename = null;

    /**
     * Create a new Generator instance.
     */
    public function __construct()
    {
        $this->file = new File;
    }

    /**
     * Compile template and generate
     *
     * @param  string $path
     * @param         $data
     * @param bool    $update
     * @return boolean
     */
    public function make($path, $data, $update = false)
    {
        $this->path = $this->getPath($path);

        $template = $this->template($data);

        if (!$this->file->exists($this->path) or $update) {
            return $this->file->put($this->path, $template) !== false;
        }

        return false;
    }

    /**
     * Get the path to the file that should be generated.
     *
     * @param  string $path
     * @return string
     */
    protected function getPath($path)
    {
        // By default, we won't do anything, but
        // it can be overridden from a child class
        return $path;
    }

    /**
     * Get compiled template.
     *
     * @param $data
     * @return null
     */
    protected function template($data)
    {
        return null;
    }
}
