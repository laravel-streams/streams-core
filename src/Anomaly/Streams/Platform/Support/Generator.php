<?php namespace Anomaly\Streams\Platform\Support;

class Generator
{
    protected $file;

    protected $compiler;

    function __construct()
    {
        $this->file = app('files');
    }

    public function make($template, $data, $path)
    {
        $template = $this->compile($template, $data);

        $this->file->put($path, $template);
    }

    public function compile($template, $data)
    {
        foreach ($data as $key => $value) {

            $template = preg_replace("/\{(" . $key . "*)\}/", $value, $template);

        }

        return $template;
    }
}
