<?php namespace Streams\Platform\Support;

class Compiler
{
    public function compile($template, $data)
    {
        foreach ($data as $key => $value) {

            $template = preg_replace("/\{(" . $key . "*)\}/", $value, $template);

        }

        return $template;
    }
}
 