<?php

namespace Anomaly\Streams\Platform\Support;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use StringTemplate\Engine;

/**
 * Class Parser
 * 
 * @todo merge this into Str via MACRO boiii
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Parser
{

    /**
     * The parser data.
     *
     * @var array
     */
    protected $data;

    /**
     * The string parser.
     *
     * @var Engine
     */
    protected $parser;

    /**
     * Create a new Parser instance.
     *
     * @param Engine $parser
     * @param Request $request
     */
    public function __construct(Engine $parser)
    {
        $this->parser = $parser;

        $this->prepareData();
    }

    /**
     * Parse data into the target recursively.
     *
     * @param        $target
     * @param  array $data
     * @return mixed
     */
    public function parse($target, array $data = [])
    {
        $data = array_merge($this->data, $this->toArray($data));

        /*
         * If the target is an array
         * then parse it recursively.
         */
        if (is_array($target)) {
            foreach ($target as $key => &$value) {
                $value = $this->parse($value, $data);
            }
        }

        /*
         * if the target is a string and is in a parsable
         * format then parse the target with the payload.
         */
        if (is_string($target) && str_contains($target, ['{', '}'])) {
            $target = $this->parser->render($target, $data);
        }

        return $target;
    }

    /**
     * Prepare the data.
     *
     * @param  array $data
     * @return array
     */
    protected function prepareData()
    {
        return $this->data = $this->detectData();
    }

    /**
     * Detect default data.
     *
     * @return array
     */
    protected function detectData()
    {
        $url     = $this->urlData();
        $request = $this->requestData();

        return compact('url', 'request');
    }

    /**
     * Prep data for parsing.
     *
     * @param  array $data
     * @return array
     */
    protected function toArray(array $data)
    {
        foreach ($data as $key => &$value) {
            if (is_object($value) && $value instanceof Arrayable) {
                $value = $value->toArray();
            }
        }

        return $data;
    }

    /**
     * Return the URL data.
     *
     * @return array
     */
    protected function urlData()
    {
        return [
            'previous' => url()->previous(),
        ];
    }

    /**
     * Return the request data.
     *
     * @return array
     */
    protected function requestData()
    {
        $request = [
            'url'      => request()->url(),
            'path'     => request()->path(),
            'root'     => request()->root(),
            'input'    => request()->input(),
            'full_url' => request()->fullUrl(),
            'segments' => request()->segments(),
            'uri'      => request()->getRequestUri(),
            'query'    => request()->getQueryString(),
        ];

        if ($route = request()->route()) {

            $request['route'] = [
                'uri'                      => $route->uri(),
                'parameters'               => $route->parameters(),
                'parameters.to_urlencoded' => array_map(
                    function ($parameter) {
                        return urlencode($parameter);
                    },
                    array_filter($route->parameters())
                ),
                'parameter_names'          => $route->parameterNames(),
                'compiled'                 => [
                    'static_prefix'     => $route->getCompiled()->getStaticPrefix(),
                    'parameters_suffix' => str_replace(
                        $route->getCompiled()->getStaticPrefix(),
                        '',
                        request()->getRequestUri()
                    ),
                ],
            ];
        }

        return $request;
    }
}
