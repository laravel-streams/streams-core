<?php

use Anomaly\Streams\Platform\Support\Parser;
use Anomaly\Streams\Platform\Support\Template;

if (!function_exists('parse')) {

    /**
     * Parse the target with data.
     *
     * @param $target
     * @param array $data
     * @return mixed    The parsed target.
     */
    function parse($target, array $data = [])
    {
        return app(Parser::class)->parse($target, $data);
    }
}

if (!function_exists('render')) {

    /**
     * Render the string template.
     *
     * @param $template
     * @param array $payload
     * @return string
     */
    function render($template, array $payload = [])
    {
        return app(Template::class)->render($template, $payload);
    }
}
