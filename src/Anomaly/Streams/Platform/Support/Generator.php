<?php namespace Anomaly\Streams\Platform\Support;

/**
 * Class Generator
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Support
 */
class Generator
{

    /**
     * Generate a file from using given template.
     *
     * @param $template
     * @param $data
     * @param $path
     */
    public function make($template, $data, $path)
    {
        $template = $this->compile($template, $data);

        app('files')->makeDirectory(dirname($path), 0755, true, true);

        app('files')->put($path, $template);
    }

    /**
     * Compile the given template.
     *
     * @param $template
     * @param $data
     * @return mixed
     */
    public function compile($template, $data)
    {
        foreach ($data as $key => $value) {

            $template = preg_replace("/\{(" . $key . "*)\}/", $value, $template);
        }

        return $template;
    }
}
