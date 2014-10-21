<?php namespace Streams\Platform\Support;

use Illuminate\Filesystem\Filesystem as File;

class Generator
{
    protected $file;
    protected $compiler;

    function __construct()
    {
        $this->file = app('files');

        $this->compiler = $this->newCompiler();
    }

    public function make($template, $data, $path)
    {
        $template = $this->compile($template, $data);

        $this->file->put($path, $template);
    }

    public function compile($template, $data)
    {
        return $this->compiler->compile($template, $data);
    }

    protected function newCompiler()
    {
        return new Compiler();
    }
}
